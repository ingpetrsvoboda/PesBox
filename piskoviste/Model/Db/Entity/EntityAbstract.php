<?php
namespace Tester\Model\Db\Entity;

use Tester\Model\Db\Entity\EntityInterface;


/**
 * Description of EntityAbstract
 *
 * @author vlse2610
 */
class EntityAbstract implements EntityInterface {
    
    /**
     * Udava stav, zda entita (vlastnosti urcene k persistovani, potrebne pro znovuvytvoreni entity)  byla persistovana.
     * 
     * @var bool 
     */
    protected $persisted = FALSE;

    /**
     * 
     * @param bool $isPersisted
     */
    public function setPersisted(bool $persisted) {
        $this->persisted = $persisted;
    }
    
    /**
     * 
     * @return bool
     */
    public function isPersisted() {
        return $this->persisted;
    }
}
