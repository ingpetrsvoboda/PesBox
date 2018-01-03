<?php
use PHPUnit\Framework\TestCase;

use Pes\Database\Handler\DbTypeEnum;

/**
 * Test Pes\Type\DbTypeEnum
 *
 * @author pes2704
 */
class DbTypeEnumTest extends TestCase {
    /**
     * vyhození výjimky pro hodnotu, která není enum typu
     */
    public function testExceptionValueNotInEnum() {
        try {
            $type = new DbTypeEnum();
            $blaType = $type('bla');   // Vyhodí výjimku
        } catch (UnexpectedValueException $uve) {
            $this->assertStringStartsWith('Value is not a constant in enum', $uve->getMessage());
        }
    }
      
    /**
     * počet konstant = 2
     */
    public function testGetConstList() {
        $type = new DbTypeEnum();        
        $this->assertEquals(2, count($type->getConstList()));
    }
    
    /**
     * pro všechny konstanty platí, že jsou daného enum typu
     * @param DbTypeEnum $enum
     * @param type $value
     * 
     * @dataProvider valuesProvider
     */
    public function testGetTypeValue(DbTypeEnum $enum, $value) {
        $this->assertSame($value, $enum($value));                 
    }    
    
    /**
     * data provider pro testGetTypeValue v bázové třídě testu
     * @return type
     */    
    public function valuesProvider() {
        $type = new DbTypeEnum();        
        foreach ($type->getConstList() as $value) {
            $data[] = array($type, $value);            
        }
        return $data;
    }
    
    /**
     * existence konstanty MySQL
     * zda hodnota konstanty je enum typu
     */
    public function testGetMysqlType() {
        $type = new DbTypeEnum();
        $this->assertSame("mysql", DbTypeEnum::MySQL);
        $this->assertSame("mysql", $type(DbTypeEnum::MySQL));
    }

    /**
     * existence konstanty MSSQL
     * zda hodnota konstanty je enum typu
     */
    public function testGetMssqlType() {
        $type = new DbTypeEnum();
        $this->assertSame("sqlsrv", DbTypeEnum::MSSQL);
        $this->assertSame("sqlsrv", $type(DbTypeEnum::MSSQL));
    }
}
