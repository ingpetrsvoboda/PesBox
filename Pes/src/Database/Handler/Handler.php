<?php
/**
 * Základní handler objekt pro SQL databáze. Využívá hotovou abstrakci PHP PDO a jde o adapter a wrapper pro PDO.
 * Pro vytvoření instance využívá dsn provider, který musí generovat dsn pro připojení k databázi, options provider, který pokytuje options pro volání PDO
 * konstruktoru (před vytvořením PDO) a attribute setter, který může nastavit atrinuty vytvořeného objektu (po vytvoření PDO).
 * Objekt implementuje všechny metody PDO (jako wrapper) a přidává metody vlastní (jako adapter).
 *
 * @author pes2704
 */
namespace Pes\Database\Handler;

use Pes\Database\Handler\ConnectionInfoInterface;
use Pes\Database\Handler\DsnProvider\DsnProviderInterface;
use Pes\Database\Handler\OptionsProvider\OptionsProviderInterface;
use Pes\Database\Handler\AttributesProvider\AttributesProviderInterface;
use Pes\Database\Statement\StatementInterface;
use Psr\Log\LoggerInterface;

class Handler extends \PDO implements HandlerInterface {
    
    /**
     *
     * @var LoggerInterface 
     */
    private $logger;
    
    /**
     * Uschovaná hodnota pro identifikaci handleru při logování
     * @var string
     */
    private $dbNick;
    
    /**
     * Čítač instancí pro logování
     * @var int 
     */
    private static $handlerCounter=0;

    /**
     * Konstruktor, přijímá povinné instanční proměnné objekty ConnectionInfo, DsnProvider, OptionsProvider, AttributesProvider a Logger. 
     * Pokud některý z těchto objektů není potřeba i tak je nutné jej dodat a pro tento účel lze použít Null varianty těchto objektů.
     * 
     * <b>Bezpečnostní rizika:</b>
     * Objekt ConnectionInfo obsahuje informace pro připojení včetně jména a hesla. Zde je bezpečnostní riziko, protože lze takový objekt někde omylem zobrazit.
     * Handler je obvykle používán na mnoha místech aplikace a často "globálně" dostupný. Proto handler objekt ConnectionInfo neukládá a jen použije pro 
     * vytvoření rodičovského PDO objektu. Objekt ConnectionInfo je také použit při volání metod objektů DsnProvider, OptionsProvider, AttributesProvider
     * a proto je žádoucí, aby ani tyto objekty ConnectionInfo ani citlivé informace z něj neukládaly.
     * 
     * @param ConnectionInfoInterface $connectionInfo Objekt obsahuje všechny parametry připojení k databázi
     * @param DsnProviderInterface $dsnProvider Provider vytváří dsn řetězec pro vytvoření Handleru (PDO)
     * @param OptionsProviderInterface $optionsProvider Provider poskytuje pole options pro nastavení options při vytváření Handleru (PDO).
     * @param AttributesProviderInterface $attributesProvider Provider poskytuje pole atributů pro nastavení atributů Handleru (PDO) po jeho vytvoření
     * @param LoggerInterface $logger Psr Logger
     */
    public function __construct(ConnectionInfoInterface $connectionInfo, 
                                DsnProviderInterface $dsnProvider,  
                                OptionsProviderInterface $optionsProvider,
                                AttributesProviderInterface $attributesProvider,
                                LoggerInterface $logger
            ) {
        self::$handlerCounter++;
        $this->dbNick = $connectionInfo->getDbNick();
        $this->logger = $logger;
        
        // Z bezpečnostních důvodů connection info nemá getter pro pass a hodnota private vlastnosti pass se zde získává reflexí. 
        // Tato hodnota se předává přímo do PDO, v objektu se neukládá.
        $rc = new \ReflectionClass($connectionInfo);
        try {
            $property = $rc->getProperty('pass');
        } catch (\ReflectionException $re) {
            // Pravděpodobně se změnilo jméno vlastnosti pass ve třídě ConnectionInfo
            throw new \UnexpectedValueException('Nepodařilo se získat skryté údaje z connection info.');
        }
        $property->setAccessible(TRUE);
        $value = $property->getValue($connectionInfo);
        $property->setAccessible(FALSE);
        
        // před voláním PDO nastaví vlastní exception handler
        set_exception_handler(array(__CLASS__, 'safeExceptionHandler'));
        parent::__construct($dsnProvider->getDsn($connectionInfo), $connectionInfo->getUser(), $value, $optionsProvider->getOptionsArray($connectionInfo));      
        // po volání PDO vrátí zpět předchozí exception handler
        restore_exception_handler();
        if ($attributesProvider) {
            $this->setAttributes($attributesProvider->getAttributesArray());
        }

    }
    
    /**
     * PRIVÁTNÍ Metoda se pokusí nastavit handleru atributy voláním PDO metody setAttrinutes().
     * Pokud se nepodaří některý atribut nastavit, metoda vyhazuje výjimku.
     * Pokud výjimka nastala díky chybě 'SQLSTATE[IM001]: Driver does not support this function: driver does not support that attribute',
     * pak metoda doplní zprávu ve výjimce o podrobný důvod.
     * 
     * @param array $attributes
     * @throws \RuntimeException
     */
    private function setAttributes($attributes) {
        foreach ($attributes as $key => $value) {
            $succ = $this->setAttribute($key, $value); 
            if (!$succ) {
                $dump = $this->dumpPDOParameters();
                $this->logger->alert($this->getInstanceInfo().' Selhalo nastavení hodnoty atributu handleru (PDO): {key} na hodnotu {value}', array('key'=>$key, 'value'=>print_r($dump, TRUE))); 
                throw new \RuntimeException($this->getInstanceInfo().' Selhalo nastavení atributu '.$key.'. '.$dump);
            }
        }
        $this->logger->info($this->getInstanceInfo().' Nastaveny hodnoty atributů handleru (PDO): {attributes}', array('attributes'=>print_r($attributes, TRUE)));            
    }
    
    /**
     * Metoda ověřuje funkčnost nastavení všech existujících atributů PDO. Pokusí se z handleru načíst postupně všechny atributy, 
     * které PDO může mít dle dokumentace a ukládá jejich aktuální hodnoty pro výpis. Pokud přečtení atributu selže, metoda z odchytnuté výjimky zjišťuje, 
     * zda příčinou je, že použitý interpret php daný atribut nepodporuje. V takovém případě uloží zprávu a nepodporovaném atributu do výpisu.
     * Výpis pak vrací jako string.
     * 
     * @return string Výpis
     */
    private function dumpPDOParameters() {
        //TODO: pro PDO::PARAM_ v options
        
        // všechny PDO ATTR atributy
        $attributes = array(
	 "ATTR_AUTOCOMMIT", "ATTR_CASE", "ATTR_CLIENT_VERSION", "ATTR_CONNECTION_STATUS", 
         "ATTR_DRIVER_NAME", "ATTR_ERRMODE", "ATTR_ORACLE_NULLS", "ATTR_PERSISTENT",
	 "ATTR_PREFETCH", "ATTR_SERVER_INFO", "ATTR_SERVER_VERSION", "ATTR_TIMEOUT"
        );

        foreach ($attributes as $attribute) {
            try {
                $attr = $this->getAttribute(constant("\PDO::$attribute"));
                $dump[] = "PDO::$attribute: (atribut číslo ".constant("\PDO::$attribute").") má hodnotu ".$attr;
            } catch (PDOException $pdoex) {
                if (strpos($pdoex->getMessage, self::CATCHED_ERROR_MESSAGE) !== FALSE) {
                    $dump[] = "Použitý PHP interpret neakceptuje atribut PDO::$attribute";
                } else {
                    throwException($pdoex);
                }
            }
        }      
        return var_export($dump, TRUE);
    }
    
    /**
     * Bezpečnostní exception handler obsluhuje pouze výjimky vyhozené v konstruktoru handleru - tedy výjimky při instancování PDO. 
     * 
     * Nezachycená výjimka PDO vede obvykle k výpisu výjimky tak, že výpis vidí uživatel. Tento výpis obvykle obsahuje údaje o připojení. 
     * Zobrazování takového výpisu je zřejmé bezpečnostní riziko. 
     * 
     * Nastavení obsluhy chyb PHP na vyhazování chyb místo výjimek nijak neovliní chování konstruktoru PDO - ten i nadále vyhazuje výjimky. 
     * Proto tato třída přidává jako bezpečnostní opatření svůj vlastní exception_handler, který zachycuje výjimky všech typů a hlásí 
     * jen základní hlášení bez podrobnách informací. Tento exception_handler musí být volán v konstruktoru této třídy před instancováním PDO, 
     * po instancování PDO je nahrazen zpět předtím nastaveným exception handlerem.
     * 
     * @param type $exception
     */
    public static function safeExceptionHandler(\Exception $exception) {
        $str2 = '';
        $i = 0;
        foreach ($exception->getTrace() as $trace) {
            $str2 .= '#'.$i.' '.$trace['file'].', line '.$trace['line'].': '.$trace['class'].$trace['type'].$trace['function']
                 .'('.\implode(',', array_map('self::varExport', $trace['args'])).')'.\PHP_EOL;
            $i++;
        }

        $this->logger->critical($this->getInstanceInfo().' '.$exception->getMessage().\PHP_EOL.$exception->getTraceAsString().\PHP_EOL.$str2);

        // Output the exception details
        throw new \UnexpectedValueException($this->getInstanceInfo().' Problém s připojením k databázi - chyba v Handleru. Kontaktujte správce systému.');//. $exception->getMessage()); //????? getMessage
    } 
    
    /**
     * Identifikace handleru pro logování
     * @return type
     */
    private function getInstanceInfo() {
        return 'Handler '.$this->dbNick.self::$handlerCounter;
    }     

    /**
     * Metoda JE použita! 
     * Volána jako funkce v metodě safeExceptionHandler()
     * @param type $param
     * @return type
     */
    private static function varExport($param) {
        return var_export($param, TRUE);
    }

    /**
     * {@inheritDoc}
     * 
     * @param string $sqlStatement SQL příkaz s případnými pojmenovanými nebo otazníkem značenými paramatery (SQL template)
     * @param type $driver_options
     * @return StatementInterface 
     */
    public function prepare($sqlStatement, $driver_options = array()) {
        if ($driver_options) {
            $this->logger->debug($this->getInstanceInfo().' prepare({sqlStatement}, {driver_options})', array('sqlStatement'=>$sqlStatement, 'driver_options'=>$driver_options));            
        } else {
            $this->logger->debug($this->getInstanceInfo().' prepare({sqlStatement})', array('sqlStatement'=>$sqlStatement));
        }
        $prepStatement = parent::prepare($sqlStatement, $driver_options); 
        return $prepStatement;
    }
    
    /**
     * {@inheritDoc}
     * 
     * @param string $sqlStatement
     * @return type
     */
    public function query(string $sqlStatement='') {
        $this->logger->debug($this->getInstanceInfo().' query({sqlStatement})', array('sqlStatement'=>$sqlStatement));
        return parent::query($sqlStatement);
    }
        
    ###############  METODY PRO DEBUG  ######################
    
    public function getDatabaseHandlerErrorInfo() {
        return var_export($this->errorInfo(), TRUE);
    }    

    
//    INSPIRACE PRO TRANSAKCE
//    http://php.net/manual/en/pdo.begintransaction.php
//         steve at fancyguy dot com ¶
//    The nested transaction example here is great, but it's missing a key piece of the puzzle.  Commits will commit everything, I only wanted commits to actually commit when the outermost commit has been completed.  This can be done in InnoDB with savepoints.
//
//    protected $transactionCount = 0;
//
//    public function beginTransaction()
//    {
//        if (!$this->transactionCounter++) {
//            return parent::beginTransaction();
//        }
//        $this->exec('SAVEPOINT trans'.$this->transactionCounter);
//        return $this->transactionCounter >= 0;
//    }
//
//    public function commit()
//    {
//        if (!--$this->transactionCounter) {
//            return parent::commit();
//        }
//        return $this->transactionCounter >= 0;
//    }
//
//    public function rollback()
//    {
//        if (--$this->transactionCounter) {
//            $this->exec('ROLLBACK TO trans'.$this->transactionCounter + 1);
//            return true;
//        }
//        return parent::rollback();
//    }

}
