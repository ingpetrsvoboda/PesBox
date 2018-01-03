<?php
use PHPUnit\Framework\TestCase;

use Pes\Query\LogicOperatorEnum;
/**
 * Test Pes\Type\LogicOperatorEnumTest
 *
 * @author pes2704
 */
class LogicOperatorEnumTest extends TestCase {
    
    /**
     * vyhození výjimky pro hodnotu, která není enum typu
     */
    public function testExceptionValueNotInEnum() {
        try {
            $type = new LogicOperatorEnum();
            $blaType = $type('bla');   // Vyhodí výjimku
        } catch (UnexpectedValueException $uve) {
            $this->assertStringStartsWith('Value is not a constant in enum', $uve->getMessage());
        }
    }
    
    /**
     * počet konstant = 2
     */
    public function testGetConstList() {
        $type = new LogicOperatorEnum();        
        $this->assertEquals(2, count($type->getConstList()));
    }
    
    /**
     * pro všechny konstanty platí, že jsou daného enum typu
     * @param \Pes\Type\Enum $enum
     * @param type $value
     * 
     * @dataProvider valuesProvider
     */
    public function testGetTypeValue(LogicOperatorEnum $enum, $value) {
        $this->assertSame($value, $enum($value));                 
    }    
    
    /**
     * data provider pro testGetTypeValue v bázové třídě testu
     * @return type
     */    
    public function valuesProvider() {
        $type = new LogicOperatorEnum();        
        foreach ($type->getConstList() as $value) {
            $data[] = array($type, $value);            
        }
        return $data;
    }
    
    /**
     * existence konstanty 
     * zda hodnota konstanty je enum typu
     */
    public function testGetDefaultAccessType() {
        $type = new LogicOperatorEnum();
        $this->assertSame('AND', LogicOperatorEnum::AND_OPERATOR);
        $this->assertSame('AND', $type(LogicOperatorEnum::AND_OPERATOR));
    }
    
    
    /**
     * existence konstanty 
     * zda hodnota konstanty je enum typu
     */
    public function testGetWritingProhibitedType() {
        $type = new LogicOperatorEnum();
        $this->assertSame('OR', LogicOperatorEnum::OR_OPERATOR);
        $this->assertSame('OR', $type(LogicOperatorEnum::OR_OPERATOR));
    }
}
