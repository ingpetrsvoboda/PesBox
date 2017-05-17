<?php
use Pes\Collection\MapCollection;
use Pes\Validator\IsTypeValidator;

interface InterfaceForIsTypeValidatorTest {
    
}
class ObjectForIsTypeValidatorTest {
    
}
class InterfacedObjectForIsTypeValidatorTest implements InterfaceForIsTypeValidatorTest {
    
}
class AnotherObjectForIsTypeValidatorTest {
    
}
/**
 * Description of IndexedCollectionTest
 *
 * @author pes2704
 */
class IsTypeValidatorTest extends PHPUnit_Framework_TestCase {
    public function testConstructor() {
        try {
            $validator = new IsTypeValidator('Blabla');   // Vyhodí výjimku
        } catch (\InvalidArgumentException $uve) {
            $this->assertStringStartsWith('No such interface or class is defined', $uve->getMessage());
        }
        try {
            $validator = new IsTypeValidator(188);   // Vyhodí výjimku
        } catch (\InvalidArgumentException $uve) {
            $this->assertStringStartsWith('Parameter must be a string.', $uve->getMessage());
        }
        $validator = new IsTypeValidator('InterfaceForIsTypeValidatorTest');      
        $validator = new IsTypeValidator('ObjectForIsTypeValidatorTest');      
    }
    
    public function testIsValid() {
        $validator = new IsTypeValidator('ObjectForIsTypeValidatorTest');      
        $this->assertTrue($validator->isValid(new ObjectForIsTypeValidatorTest()));
        $this->assertFalse($validator->isValid(new AnotherObjectForIsTypeValidatorTest()));
        $validator = new IsTypeValidator('InterfaceForIsTypeValidatorTest');      
        $this->assertTrue($validator->isValid(new InterfacedObjectForIsTypeValidatorTest()));
        $this->assertFalse($validator->isValid(new AnotherObjectForIsTypeValidatorTest()));    }
    
    
}
