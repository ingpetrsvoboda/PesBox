<?php
use Pes\Query\Order;
use Pes\Type\OrderingEnum;

/**
 * Description of testOrder
 *
 * @author pes2704
 */
class OrderTest extends PHPUnit_Framework_TestCase {
    /**
     * @var Order 
     */
    protected $order;
    
    public function setUp() {
        $this->order = (new Order())
            ->addOrdering('a', OrderingEnum::DESCENDING)
            ->addOrdering('n', OrderingEnum::ASCENDING)
            ->addOrdering('x', OrderingEnum::DESCENDING);  
    }
    public function testGetSqlString() {
    
        $str = $this->order->getSqlString();
        $this->assertEquals('a DESC, n ASC, x DESC', $str);
    }
    
    public function testIterator() {
        foreach ($this->order as $ordering) {
            $arr[$ordering['attribute']] = $ordering['type'];
        }
        $this->assertEquals(array('a'=>'DESC', 'n'=>'ASC', 'x'=>'DESC'), $arr);
    }
}