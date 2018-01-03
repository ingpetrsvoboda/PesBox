<?php
use PHPUnit\Framework\TestCase;

use Pes\Query\ColumnAccessEnum;

/**
 * Test Pes\Type\ColumnAccessEnum
 *
 * @author pes2704
 */
class ColumnAccessEnumTest extends TestCase {
    
    /**
     * vyhození výjimky pro hodnotu, která není enum typu
     */
    public function testExceptionValueNotInEnum() {
        try {
            $type = new ColumnAccessEnum();
            $blaType = $type('bla');   // Vyhodí výjimku
        } catch (UnexpectedValueException $uve) {
            $this->assertStringStartsWith('Value is not a constant in enum', $uve->getMessage());
        }
    }
    
    /**
     * počet konstant = 4
     */
    public function testGetConstList() {
        $dbType = new ColumnAccessEnum();        
        $this->assertEquals(4, count($dbType->getConstList()));
    }
    
    /**
     * pro všechny konstanty platí, že jsou daného enum typu
     * @param \Pes\Type\Enum $enum
     * @param type $value
     * 
     * @dataProvider valuesProvider
     */
    public function testGetTypeValue(ColumnAccessEnum $enum, $value) {
        $this->assertSame($value, $enum($value));                 
    }    
    
    /**
     * data provider pro testGetTypeValue v bázové třídě testu
     * @return type
     */    
    public function valuesProvider() {
        $type = new ColumnAccessEnum();        
        foreach ($type->getConstList() as $value) {
            $data[] = array($type, $value);            
        }
        return $data;
    }
    
    /**
     * existence konstanty MySQL
     * zda hodnota konstanty je enum typu
     */
    public function testGetDefaultAccessType() {
        $type = new ColumnAccessEnum();
        $this->assertSame('default_access', ColumnAccessEnum::DEFAULT_ACCESS);
        $this->assertSame('default_access', $type(ColumnAccessEnum::DEFAULT_ACCESS));
    }
    
    
    /**
     * existence konstanty MySQL
     * zda hodnota konstanty je enum typuype
     */
    public function testGetWritingProhibitedType() {
        $type = new ColumnAccessEnum();
        $this->assertSame('writing_prohibited', ColumnAccessEnum::WRITING_PROHIBITED);
        $this->assertSame('writing_prohibited', $type(ColumnAccessEnum::WRITING_PROHIBITED));
    }
    
    
    /**
     * existence konstanty MySQL
     * zda hodnota konstanty je enum typu
     */
    public function testGetUpdateProhibitedType() {
        $type = new ColumnAccessEnum();
        $this->assertSame('update_prohibited', ColumnAccessEnum::UPDATE_PROHIBITED);
        $this->assertSame('update_prohibited', $type(ColumnAccessEnum::UPDATE_PROHIBITED));
    }
    
    
    /**
     * existence konstanty MySQL
     * zda hodnota konstanty je enum typu
     */
    public function testGetAlwaysWriteableType() {
        $type = new ColumnAccessEnum();
        $this->assertSame('always_writeable', ColumnAccessEnum::ALWAYS_WRITEABLE);
        $this->assertSame('always_writeable', $type(ColumnAccessEnum::ALWAYS_WRITEABLE));
    }    
}
