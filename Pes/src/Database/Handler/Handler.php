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
use Pes\Database\Statement\CacheInterface;
use Psr\Log\LoggerInterface;

class Handler extends \PDO implements HandlerInterface {
    
    /**
     *
     * @var LoggerAwareInterface 
     */
    private $logger;
    
    /**
     *
     * @var CacheInterface
     */
    private $statementCache;   

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
     * @param CacheInterface $statementCache Cache pro ukládání vzniklých objektů Statement
     */
    public function __construct(ConnectionInfoInterface $connectionInfo, 
                                DsnProviderInterface $dsnProvider,  
                                OptionsProviderInterface $optionsProvider,
                                AttributesProviderInterface $attributesProvider,
                                LoggerInterface $logger,
                                CacheInterface $statementCache = NULL
            ) {

        $this->logger = $logger;
        $this->statementCache = $statementCache;
        // Z bezpečnostních důvodů connection info nemá getter pro pass a hodnota private vlastnosti pass se zde získává reflexí. 
        // Tato hodnota se předává přímo do PDO, v objektu se neukládá.
        $rc = new \ReflectionClass($connectionInfo);
        try {
            $property = $rc->getProperty('pass');
        } catch (\ReflectionException $re) {
            // Pravděpodobně se změnilo jméno vlastnosti pass ve třídě ConnectionInfo
            throw new \UnexpectedValueException('Nepodařilose získat skryté údaje z connection info.');
        }
        $property->setAccessible(TRUE);
        $value = $property->getValue($connectionInfo);
        $property->setAccessible(FALSE);
        
        // před voláním PDO nastaví vlastní exception handler
        set_exception_handler(array(__CLASS__, 'safeExceptionHandler'));
        parent::__construct($dsnProvider::getDsn($connectionInfo), $connectionInfo->getUser(), $value, $optionsProvider::getOptionsArray($connectionInfo));      
        // po volání PDO vrátí zpět předchozí exception handler
        restore_exception_handler();
        if ($attributesProvider) {
            $this->setAttributes($attributesProvider::getAttributesArray($connectionInfo));
        }

    }
    
    /**
     * Metoda se pokusí nastavit handleru atributy voláním PDO metody setAttrinutes().
     * Pokud se nepodaří některý atribut nastavit, metody vyhazuje výjimku.
     * Pokud výjimka nastala díky chybě 'SQLSTATE[IM001]: Driver does not support this function: driver does not support that attribute',
     * pak metoda doplní zprávu ve výjimce o podrobný důvod.
     * @param \Pes\Database\Handler\Handler $handler
     * @throws \RuntimeException
     */
    private function setAttributes($attributes) {
        foreach ($attributes as $key => $value) {
            $succ = $this->setAttribute($key, $value);            
            if (!$succ) {
                $dump = $this->dumpPDOParameters($handler);
                throw new \RuntimeException('Selhalo nastavení atributu '.$key.'. '.$dump);
            }
        }
    }
    
    /**
     * Metoda ověřuje funkčnost nastavení všech existujících atributů PDO. Pokusí se z handleru načíst postupně všechny atributy, 
     * které PDO může mít dle dokumentace a ukládá jejich aktuální hodnoty pro výpis. Pokud přečtení atributu selže, metoda z odchytnuté výjimky zjišťuje, 
     * zda příčinou je, že použitý interpret php daný atribut nepodporuje. V takovém případě uloží zprávu a nepodporovaném atributu do výpisu.
     * Výpis pak vrací jako string.
     * 
     * @return string Výpis
     */
    private function dumpPDOParameters(Handler $handler) {
        //TODO: pro PDO::PARAM_ v options
        
        // všechny PDO ATTR atributy
        $attributes = array(
            "ATTR_AUTOCOMMIT", "ATTR_ERRMODE", "ATTR_CASE", "ATTR_CLIENT_VERSION", "ATTR_CONNECTION_STATUS",
            "ATTR_ORACLE_NULLS", "ATTR_PERSISTENT", "ATTR_SERVER_INFO", "ATTR_SERVER_VERSION",
//            "TIMEOUT"
        );

        foreach ($attributes as $attribute) {
            try {
                $attr = $handler->getAttribute(constant("\PDO::$attribute"));
                $dump[] = "PDO::$attribute: (atribut číslo ".constant("\PDO::_$attribute").") má hodnotu ".$attr;
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
     * Exception handler obsluhuje pouze výjimky vyhozené v konstruktoru handleru - tedy výjimky PDO. Nezachycená výjimka PDO vede obvykle k výpisu výjimky 
     * tak, že výpis vidí uživatel. Tento výpis obvykle obsahuje údaje o připojení. Zobrazování takového výpisu je zřejmé bezpečnostní riziko. 
     * Nastevení obsluhy chyb PHP na vyhazování chyb místo výjimek nijak neovliní chování konstruktoru PDO - ten i nadále vyhazuje výjimky. 
     * Proto tato třída přidává jako bezpečnostní opatření svůj vlastní exception_handler, který zachycuje výjimky všech typů a hlásí 
     * jen zákadní hlášení. Tento exception_handler musí být volán v konstruktoru této třídy před instancováním PDO poté je nahrazen zpět předtím 
     * nastaveným exception handlerem.
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

        $this->logger->critical($exception->getMessage().\PHP_EOL.$exception->getTraceAsString().\PHP_EOL.$str2);

        // Output the exception details
        throw new \UnexpectedValueException('Problém s připojením k databázi - chyba v Handleru. Kontaktujte správce systému.');//. $exception->getMessage()); //????? getMessage
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
     * Metoda mění adapter na kombinaci adapteru a wrapperu. Pro metody implementované v této třídě se objekt chová jako adapter, 
     * volá se implementovaná metoda třídy. Pro neimplementované metody se volá metoda "obaleného" objektu, v tomto případě tedy metoda PDO.
     * @param type $method
     * @param array $arguments
     * @return type
     */
    public function __call($method, array $arguments )
    {
        return \call_user_func_array(array($this, $method), $arguments);
    } 

    /**
     * Rozsiřuje funkčnost PDO prepare o možnost cachování připravených (prepare) objektů statement.
     * @param string $sqlStatement SQL příkaz s případnými pojmenovanými nebo otazníkem značenými paramatery (SQL template
     * @param type $driver_options
     * @return type
     */
    public function prepare($sqlStatement, $driver_options = array()) {
        if ($this->statementCache) {
            $signature = $sqlStatement.serialize($driver_options);
            if ($this->statementCache->hasStatement($signature)) {
                $sqlStatement = $this->statementCache->getStatement($signature);
            } else {
                $sqlStatement = parent::prepare($sqlStatement, $driver_options);
                $this->statementCache->setStatement($signature, $sqlStatement);
            }
        } else {
            $sqlStatement = parent::prepare($sqlStatement, $driver_options);            
        }
        return $sqlStatement;
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
