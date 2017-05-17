<?php
use Pes\Collection\SetCollection;
use Pes\Validator\IsTypeValidator;
use Pes\Comparator\OrderComparator;
use Pes\Comparator\SortComparator;
use Pes\Query\Order;
use Pes\Type\OrderingEnum;

interface InterfaceForSetCollectionTest {
    
}
class ObjectForSetCollectionTest {
    
}
class InterfacedObjectForSetCollectionTest implements InterfaceForSetCollectionTest {
    
}
class EntitkaForSetCollectionTest {
    public $a, $n, $x;
    public function __construct($a, $n, $x) {
        $this->a = $a;
        $this->n = $n;
        $this->x = $x;
    }
}

// není test pro nevé dodělou metodu has()!

/**
 * Description of SetCollectionTest
 * Nejde o čistý jednotkový test - testuje předevčím SetCollection, ale používá řadu dalších objektů.
 *
 * @author pes2704
 */
class SetCollectionTest extends PHPUnit_Framework_TestCase {
    public function testConstructor() {
        $collection = new SetCollection();
        $this->assertInstanceOf('Pes\Collection\SetCollection', $collection);
        $validator = new IsTypeValidator('InterfaceForSetCollectionTest');
//        $validatorMock = $this->getMockBuilder('IsTypeValidator')->getMock();
//        $validatorMock->eexpects($this->any())-
        $collection = new SetCollection(NULL, $validator);
        $this->assertInstanceOf('Pes\Collection\SetCollection', $collection);
    }
    
    public function testSetRemove() {
        $collection = new SetCollection();
        $obj = new EntitkaForSetCollectionTest('a', 'n', 'x');
        $collection->set($obj);
        $collection->set(new stdClass());
        $this->assertEquals(2, $collection->count());
        $collection->remove($obj);
        $this->assertEquals(1, $collection->count());
    }
    
    public function testSetWithValidation() {
        $validator = new IsTypeValidator('InterfaceForSetCollectionTest');
        $collection = new SetCollection(NULL, $validator);        
        $validObj = new InterfacedObjectForSetCollectionTest();
        $invalidObj = new ObjectForSetCollectionTest();
        $collection->set($validObj); //přidá 
        $this->assertEquals(1, $collection->count());
        $collection->set($invalidObj); // nepřidá - nedělá nic
        $this->assertEquals(1, $collection->count()); //jeden prvek kolekce
    }
    
    public function testExchangeContentAndCountAndGetIterator() {
        // pole
        $source = array('aa', 'bb');
        $collection = new SetCollection($source);
        $this->assertEquals('2', $collection->count());
        $collection = new SetCollection();
        $collection->mergeArrayContent($source); 
        $this->assertEquals('2', $collection->count());
        //přidá další 2 - jiné indexy
        $collection = new SetCollection(array('cc', 'dd'));
        $collection->mergeArrayContent($source); 
        $this->assertEquals('4', $collection->count());
        
        $source = array(
            new ObjectForSetCollectionTest(),
            new ObjectForSetCollectionTest(),
            new ObjectForSetCollectionTest());
        
        $collection = new SetCollection($source);
        $this->assertEquals('3', $collection->count());
        $ret = array();
        foreach ($collection as $value) { // test get iterator
            $ret[] = $value;
        }
        $this->assertEquals($source, $ret);
        
        $collection = new SetCollection();
        $collection->mergeArrayContent($source);
        $this->assertEquals('3', $collection->count());
        $ret = array();
        foreach ($collection as $value) { // test get iterator
            $ret[] = $value;
        }
        $this->assertEquals($source, $ret);
    }
    
    public function testOrder() {
        $source = array(
            new EntitkaForSetCollectionTest('004', '03', '1'),
            new EntitkaForSetCollectionTest('003', '01', '5'),
            new EntitkaForSetCollectionTest('001', '02', '2'),
            new EntitkaForSetCollectionTest('003', '02', '1'),
            new EntitkaForSetCollectionTest('003', '01', 'aa'),
            new EntitkaForSetCollectionTest('001', '02', '1'),
            new EntitkaForSetCollectionTest('005', '01', '1'),
            new EntitkaForSetCollectionTest('001', '01', '1'),
            new EntitkaForSetCollectionTest('004', '02', '1'),
            new EntitkaForSetCollectionTest('003', '01', '1'),
            new EntitkaForSetCollectionTest('004', '01', '1'),
        );
        $order = (new Order())->addOrdering('a', OrderingEnum::DESCENDING)->addOrdering('n', OrderingEnum::ASCENDING)->addOrdering('x', OrderingEnum::DESCENDING);      
        $ordered = array(
            new EntitkaForSetCollectionTest('005', '01', '1'),
            new EntitkaForSetCollectionTest('004', '01', '1'),
            new EntitkaForSetCollectionTest('004', '02', '1'),
            new EntitkaForSetCollectionTest('004', '03', '1'),
            new EntitkaForSetCollectionTest('003', '01', 'aa'),
            new EntitkaForSetCollectionTest('003', '01', '5'),
            new EntitkaForSetCollectionTest('003', '01', '1'),
            new EntitkaForSetCollectionTest('003', '02', '1'),
            new EntitkaForSetCollectionTest('001', '01', '1'),
            new EntitkaForSetCollectionTest('001', '02', '2'),
            new EntitkaForSetCollectionTest('001', '02', '1'),
        );
        $collection = new SetCollection();
        $collection->mergeArrayContent($source);
        $collection->sort(OrderComparator::getCompareFunction($order));
        foreach ($collection as $key => $value) { 
// iterator iteruje v ordered pořadí, ALE hodnoty $key obsahují původní indexy, se kterými byli členové kolekce setováni
            // nefunguje tedy $ret[$key] = $value - takové pole se nerovná ordered
            $ret[] = $value;
        }
        $this->assertEquals($ordered, $ret);        
    }

    public function testSort() {
        $source = array(
            new EntitkaForSetCollectionTest('004', '03', '1'),
            new EntitkaForSetCollectionTest('003', '01', '5'),
            new EntitkaForSetCollectionTest('001', '02', new EntitkaForSetCollectionTest('blx', 'ble', 'bli')),
            new EntitkaForSetCollectionTest('003', '02', '1'),
            new EntitkaForSetCollectionTest('003', '01', 'aa'),
            new EntitkaForSetCollectionTest('001', '02', new EntitkaForSetCollectionTest('bla', 'ble', 'bli')),
            new EntitkaForSetCollectionTest('005', '01', '1'),
            new EntitkaForSetCollectionTest('001', '01', '1'),
            new EntitkaForSetCollectionTest('004', '02', '1'),
            new EntitkaForSetCollectionTest('003', '01', '1'),
            new EntitkaForSetCollectionTest('004', '01', '1'),
        );
        $order = (new Order())->addOrdering('a', OrderingEnum::DESCENDING)->addOrdering('n', OrderingEnum::ASCENDING)->addOrdering('x', OrderingEnum::DESCENDING);     
        $ordered = array(
            new EntitkaForSetCollectionTest('005', '01', '1'),
            new EntitkaForSetCollectionTest('004', '01', '1'),
            new EntitkaForSetCollectionTest('004', '02', '1'),
            new EntitkaForSetCollectionTest('004', '03', '1'),
            new EntitkaForSetCollectionTest('003', '01', 'aa'),
            new EntitkaForSetCollectionTest('003', '01', '5'),
            new EntitkaForSetCollectionTest('003', '01', '1'),
            new EntitkaForSetCollectionTest('003', '02', '1'),
            new EntitkaForSetCollectionTest('001', '01', '1'),
            new EntitkaForSetCollectionTest('001', '02', new EntitkaForSetCollectionTest('blx', 'ble', 'bli')),
            new EntitkaForSetCollectionTest('001', '02', new EntitkaForSetCollectionTest('bla', 'ble', 'bli')),
        );
        $collection = new SetCollection();
        $collection->mergeArrayContent($source);
        $collection->sort(SortComparator::getCompareFunction($order));
        foreach ($collection as $key => $value) { 
// iterator iteruje v ordered pořadí, ALE hodnoty $key obsahují původní indexy, se kterými byli členové kolekce setováni
            // nefunguje tedy $ret[$key] = $value - takové pole se nerovná ordered
            $ret[] = $value;
        }
        $this->assertEquals($ordered, $ret);        
    }    
}
