<?php
namespace Pes\Type;

/**
 * Emuluje typ Enum (obdobně jako SplEnum)
 * 
 * SplEnum: This » PECL extension is not bundled with PHP. 
 * 
 * <p>Použití - definice typu</p>
 * <code>
 * namespace Framework\DBPDO;
 * use Framework\Type\Enum;
 * class DbType extends Enum { *     
 *     const MySQL = 'mysql';
 *     const MSSQL = 'mssql';
 * }
 * </code>
 * <p>Vytvoření proměnné</p>
 * <code>
 * try {
 *     $dbType = new DbType();
 *     $msType = $dbType(DbType::MSSQL)   //OK, vrací hodnotu 'mssql'
 *     $blaType = $dbType('bla'); // Vyhodí výjimku
 * } catch (UnexpectedValueException $uve) {
 *     echo $uve->getMessage() . PHP_EOL;
 * }
 * </code>
 * <p>Bezpečné vytvoření proměnné (bez rizika vyhozené výjimky)</p>
 * <code>
 *     $dbType = new DbType();
 *     $msType = $dbType(DbType::MSSQL)   //OK, vrací hodnotu 'mssql'
 * </code>
 * <p>Test "if"</p>
 * <code>
 * //call:
 * $dbType = new DbType();
 * $someObject->someMethod($dbType, DbType::MySQL);
 * //test:
 * function someMethod(DbType $enum, $value) {
 *      if ($value == $enum($value)) {   };                 
 * }    
 * </code>
 * @author pes2704
 */
abstract class Enum {
    
    private $constants;
    
    public function __invoke($value) {
        $this->setConstants();
        $key = array_search($value, $this->constants);
        if ($key !== FALSE) {
            return $this->constants[$key];
        } else {
            if (is_scalar($value)) {
                throw new \UnexpectedValueException('Value is not a constant in enum '. get_called_class().'. Value: '.var_export($value, TRUE).'.');
            } else {
                throw new \UnexpectedValueException('Value is not a constant in enum '. get_called_class());                
            }
        }
    } 
    
    /**
     * Kompatibilata s SplEnum
     */
    public function getConstList() {
        $this->setConstants();
        return $this->constants;
    }
    
    private function setConstants() {
        if (!isset($this->constants)) {
            $reflexCls = new \ReflectionClass(get_called_class());
            $this->constants = $reflexCls->getConstants();
        }        
    }
}