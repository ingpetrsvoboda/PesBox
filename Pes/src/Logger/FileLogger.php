<?php
namespace Pes\Logger;

use Psr\Log\AbstractLogger;
use Pes\Utils\Directory;

/**
 * Description of FileLogger
 * Třída loguje tak, že zapisuje do souboru. Pro každý soubor vytváří jednu istanci objektu Projektor_Model_Auto_Autocode_Logger, je to singleton
 * pro jeden logovací soubor.
 *
 * @author pes2704
 */
class FileLogger extends AbstractLogger {

    /**
     *
     * @var FileLogger array of 
     */
    private static $instances = array();

    private $loggerFullLogFileName;
    private $logFileHandle;

    const ODSAZENI = "    ";    
    
    const REWRITE_LOG = 'w+';
    const APPEND_TO_LOG = 'a+';
    
    /**
     * Privátní konstruktor. Objekt je vytvářen voláním factory metody getInstance().
     * @param Resource $logFileHandle
     */
    private function __construct($logFileHandle, $fullLogFileName){
        $this->logFileHandle = $logFileHandle;
        $this->loggerFullLogFileName = $fullLogFileName;  //proměnná jen pro přehlednost při debugování - i vrácená instance obsahuje název souboru
    }

    final public function __clone(){}

    final public function __wakeup(){}

    /**
     * Factory metoda, metoda vrací instanci objektu. 
     * Objekt je vytvářen jako singleton - vždy pro jeden logovací soubor. Parametr $mode určuje zda soubor je při zahájení logování přepsán novým obsahem - log 
     * obsahuje zápisy jen z jednoho běhu skriptu nebo zda nový obsah je přidáván na konec souboru - log obsahuje všechny zápisy.
     * 
     * @param string $logDirectoryPath Pokud parametr není zadán, třída loguje do složky, ve které je soubor s definicí třídy.
     * @param string $logFileName Název logovacího souboru (řetězec ve formátu jméno.přípona např. Mujlogsoubor.log). 
     * @param type $mode
     * 
     * @return FileLogger
     */
    public static function getInstance($logDirectoryPath, $logFileName, $mode = self::REWRITE_LOG) {
        $logDirectoryPath = Directory::normalizePath($logDirectoryPath);
        Directory::createDirectory($logDirectoryPath);

        $fullLogFileName = $logDirectoryPath.$logFileName;
        if(!isset(self::$instances[$fullLogFileName])){
            switch ($mode) {
                case self::REWRITE_LOG:
                    $fopenMode = self::REWRITE_LOG;
                    break;
            case self::APPEND_TO_LOG:
                    $fopenMode = self::APPEND_TO_LOG;
                    break;
                default:
                    $fopenMode = self::APPEND_TO_LOG;                    
                    user_error('Zadán neznámý parametr $mode při vytváření loggeru. Použit mode APPEND_TO_LOG.', E_USER_WARNING);
                    break;
            }
            $handle = fopen($fullLogFileName, $fopenMode); 
            if ($handle===FALSE) {
                throw new \InvalidArgumentException('Nelze vytvořit '.__CLASS__.' pro soubor: '.$fullLogFileName.', nepodařilo se soubor vytvořit.');
            }
            self::$instances[$fullLogFileName] = new self($handle, $fullLogFileName);
        }
        return self::$instances[$fullLogFileName];
    }
    
    /**
     * Zápis jednoho záznamu do logu. 
     * 
     * Záznam začíná prefixem uzavřeným do hranatých závorek, následuje zpráva.
     * 
     * Podřetězce zprávy mohou být nahrazeny hodnotami z asociativního pole context. Metoda použije zprávu jako šablonu a ve zprávě nahradí řetězce uzavřené 
     * ve složených závorkách hodnotami pole $context s klíčem rovným nahrazovanému řetězci. 
     * 
     * Víceřádková zpráva je uložena do více řádek logu tak, že první řádka obsahuje prefix v hranatých závorkách a další řádky jsou zleva odsazeny.
     * 
     * Příklad:
     * volání logger->log('POZOR!', 'Toto je hlášení o chybě '.PHP_EOL.'v souboru file na řádku line.', ['file=>'Ukázka.ext', 'line'=>159]
     * vytvoří záznam: 
     * <pre>
     * [POZOR!] Toto je hlášení o chybě 
     *     v souboru Ukázka.ext na řádku 159.
     * </pre>
     * 
     * @param string $level Prefix záznamu zdůrazněný uzavřením do hranatých závorek 
     * @param string $message Zpráva pro zaznamenání do logu
     * @param array $context Pole náhrad.
     * @return null
     */
    public function log($level, $message, array $context = array()) {
        $completedMessage = isset($context) ? $this->interpolate($message, $context) : $message;
        $completedMessage = preg_replace("/\r\n|\n|\r/", PHP_EOL.self::ODSAZENI, $completedMessage);  //odsazení druhé a dalších řádek víceřádkového message
        $newString = '['.$level.'] '.$completedMessage.PHP_EOL;
        fwrite($this->logFileHandle, $newString);
    }

    /**
     * Použije $message jako šablonu a nahradí slova ve složených závorkách hodnotami pole $context s klíčem rovným nahrazovanému slovu.
     */
    public function interpolate($message, array $context = array()) {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            // check that the value can be casted to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
     
    public function getLogFilePath() {
        return $this->loggerFullLogFileName;
    }
    
    /**
     * Metoda vrací aktuální obsah logovacího souboru..
     * @return string
     */
    public function getLogText() {
        $position = ftell($this->logFileHandle);
        $r = rewind($this->logFileHandle);
        return $position ? fread($this->logFileHandle, $position) : '';
    }
        
    /**
     * Magická metoda. Umožňuje například předávat objekt loggeru jako proměnnou do kontextu View - pak dojde k volání této metody
     * obvykle až když dochází k převodu view a proměnných kontextu na string. To se v Pes view obvykle dějě až na konci běhu skriptu nebo při 
     * vytváření bydy responsu a v té době již log obsahuje údaje zapsané v průběhu běhu skriptu.
     * 
     * @return string
     */
    public function __toString() {
        return $this->getLogText();
    }

    /**
     * Destruktor. Zavře logovací soubor.
     */
    public function __destruct() {
        foreach (self::$instances as $key => $instance) {
            if (is_resource($instance->logFileHandle)) {
                fclose($instance->logFileHandle);
            }
        }

    }    
}

