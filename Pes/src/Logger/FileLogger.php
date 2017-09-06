<?php
namespace Pes\Logger;

use Psr\Log\AbstractLogger;

/**
 * Description of FileLogger
 * Třída loguje tak, že zapisuje do souboru. Pro každý soubor vytváří jednu istanci objektu Projektor_Model_Auto_Autocode_Logger, je to singleton
 * pro jeden logovací soubor.
 *
 * @author pes2704
 */
class FileLogger extends AbstractLogger {

    private static $instances = array();

    private $loggerFullLogFileName;
    private $logFileHandle;

    const ODSAZENI = "    ";    
    
    /**
     * Privátní konstruktor. Objekt je vytvářen voláním factory metody getInstance().
     * @param Resource $logFileHandle
     */
    private function __construct($logFileHandle, $fullLogFileName){
        if (!is_resource($logFileHandle)) {
            throw new \InvalidArgumentException('Cannot create '.__CLASS__.'. Invalid resource handle: '.print_r($logFileHandle, TRUE));
        }
        $this->logFileHandle = $logFileHandle;
        $this->loggerFullLogFileName = $fullLogFileName;  //proměnná jen pro přehlednost při debugování - i vrácená instance obsahuje název souboru
    }

    final public function __clone(){}

    final public function __wakeup(){}

    /**
     * Factory metoda, metoda vrací instanci objektu. 
     * Objekt je vytvářen jako singleton vždy pro jeden logovací soubor. Metoda vrací jeden unikátní 
     * objekt pro jednu kombinaci parametrů $pathPrefix a $logFileName.
     * @param string $logDirectoryPath Pokud parametr není zadán, třída loguje do složky, ve které je soubor s definicí třídy.
     * @param string $logFileName Název logovacího souboru (řetězec ve formátu jméno.přípona např. Mujlogsoubor.log). 
     * 
     * @return FileLogger
     */
    public static function getInstance($logDirectoryPath, $logFileName) {
        $logDirectoryPath = str_replace('/', '\\', $logDirectoryPath);  //obrácená lomítka
        if (substr($logDirectoryPath, -1)!=='\\') {  //pokud path nekončí znakem obrácené lomítko, přidá ho
            $logDirectoryPath .='\\';
        }
        if (!is_dir($logDirectoryPath)) {  //pokud není složka, vytvoří ji
            mkdir($logDirectoryPath);
        }

        $fullLogFileName = $logDirectoryPath.$logFileName;
        if(!isset(self::$instances[$fullLogFileName])){
            $handle = fopen($fullLogFileName, 'w+'); //vymaže obsah starého logu
            self::$instances[$fullLogFileName] = new self($handle, $fullLogFileName);
        }
        return self::$instances[$fullLogFileName];
    }
    
    /**
     * Zápis jednoho záznamu do logu. Metoda přijímá argumenty, které lze převést do čitelné podoby.
     * 
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array()) {
        $completedMessage = isset($context) ? $this->interpolate($message, $context) : $message;
        $completedMessage = preg_replace("/\r\n|\n|\r/", self::ODSAZENI.PHP_EOL, $completedMessage);

        $newString = '['.$level.'] '.$completedMessage.PHP_EOL;
        fwrite($this->logFileHandle, $newString);
    }

    /**
     * Interpolates context values into the message placeholders.
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
        if ($this->logFileHandle) fclose($this->logFileHandle);
    }    
}

