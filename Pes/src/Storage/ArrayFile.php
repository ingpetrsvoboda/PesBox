<?php
/**
 * Třída pro ukládání informací do souboru.
 *
 * @author pes2704
 */
class Framework_Storage_ArrayFile extends Framework_Storage_StorageAbstract implements Framework_Storage_StorageInterface {
    
    /**
     * Default soubor
     */
    const DEFAULT_STORAGE_FILE = "Storage.file";
    /**
     * Default nově vytvářená složka
     */
    const DEFAULT_NEW_DIRECTORY = "Storage";
    
    private static $instances = array();

    private $fullStorageFileName;   
    
    /**
     * Pole pro uložení obsahu storage souboru
     * @var array 
     */
    protected $arrayContent = array();    

    /**
     * Privátní konstruktor. Objekt je vytvářen voláním factory metody getInstance().
     * @param type $fullStorageFileName
     * @throws \InvalidArgumentException
     */
    private function __construct($fullStorageFileName){
        $this->fullStorageFileName = $fullStorageFileName;
        if (is_readable($this->fullStorageFileName)) {
            $handle = fopen($this->fullStorageFileName, 'r'); //readonly
            if ($handle == FALSE) {
                throw new \InvalidArgumentException('Cannot create '.__CLASS__.'. Can\'t open storage file name: '.print_r($this->fullStorageFileName, TRUE));
            }
            $str = fread($handle, filesize($this->fullStorageFileName));
            $this->arrayContent = $this->valueRestored($str);
            if (!is_array($this->arrayContent)) {
                throw new \InvalidArgumentException('Cannot create '.__CLASS__.'. Storage file with name: '.print_r($this->fullStorageFileName, TRUE)
                        .'  contains no serialized array');
            }            
        } else {
            $this->arrayContent = array();
        }

    }

    final public function __clone(){}

    final public function __wakeup(){}

    /**
     * Factory metoda, metoda vrací instanci objektu třídy Framework_Storage_File. 
     * Objekt Framework_Storage_File je vytvářen jako singleton vždy pro jeden soubor. Metoda vrací jeden unikátní 
     * objekt pro jednu kombinaci parametrů $storageDirectoryPath a $storageFileName.
     * 
     * @param string $storageDirectoryPath Pokud parametr není zadán, třída loguje do složky, ve které je soubor s definicí třídy.
     * @param string $storageFileName Název logovacího souboru (řetězec ve formátu jméno.přípona např. Mujlogsoubor.log). Pokud parametr není zadán,
     *  třída loguje do souboru se jménem v konstantě třídy LOG_SOUBOR.
     * @return Framework_Storage_ArrayFile
     */
    public static function getInstance($storageDirectoryPath=NULL, $storageFileName=NULL) {
        if (!$storageDirectoryPath) {
            $storageDirectoryPath = __DIR__."\\".self::DEFAULT_NEW_DIRECTORY."\\"; //složka Storage jako podsložka aktuálního adresáře
        }
        $storageDirectoryPath = str_replace('/', '\\', $storageDirectoryPath);  //obrácená lomítka
        if (substr($storageDirectoryPath, -1)!=='\\') {  //pokud path nekončí znakem obrácené lomítko, přidá ho
            $storageDirectoryPath .='\\';
        }
        if (!is_dir($storageDirectoryPath)) {  //pokud není složka, vytvoří ji
            mkdir($storageDirectoryPath);
        }
        if (!$storageFileName) {
            $storageFileName = self::DEFAULT_STORAGE_FILE;
        }
        $fullStorageFileName = $storageDirectoryPath.$storageFileName;
        
//        zjisti existenci file, když ne nové array, jinak open r a deserializace a close.
        if(!isset(self::$instances[$fullStorageFileName]) OR !self::$instances[$fullStorageFileName]){
            self::$instances[$fullStorageFileName] = new self($fullStorageFileName);
        }
        return self::$instances[$fullStorageFileName];
    }    

    /**
     * Metoda přečte a vrátí hodnotu uloženou pod daným klíčem (identifikátorem).
     * @param string $key Klíč (identifikátor) hodnoty 
     * @return mixed/null
     * @throws UnexpectedValueException
     */
    public function get($key) {
        $index = $this->checkKeyValidity($key);
        if (isset($this->arrayContent[$index])) {
            return $this->arrayContent[$index];
        } else {
            return FALSE;            
        }
    }

    /**
     * Metoda uloží zadanou hodnotu pod klíčem (identifikátorem). Metoda vrací poslední uloženou hodnotu
     * @param string $key Klíč (identifikátor)
     * @param mixed $value Hodnota musí být skalární.
     * @return mixed/null
     * @throws UnexpectedValueException
     */
    public function set($key, $value) {
        $index = $this->checkKeyValidity($key);
        $this->arrayContent[$index] = $value;
        return $this->arrayContent[$index];
    }

    /**
     * Metoda odstraní (unset) hodnotu ze session.
     * @param type $key Klíč (identifikátor) hodnoty
     * @return mixed Výsledná hodnota v session. Pokud je metoda úspěšná vrací NULL.
     * @throws UnexpectedValueException
     */
    public function remove($key) {
        $index = $this->checkKeyValidity($key);
        unset($this->arrayContent[$index]);
    }

    /**
     * Destruktor. Zavře soubor.
     */
    public function __destruct() {
        $handle = fopen($this->fullStorageFileName, 'w'); //writeonly, smaže starý obsah
        fwrite($handle, $this->valueToStore($this->arrayContent));
        if ($handle) {
            fclose($handle);
        }
    }  

}
