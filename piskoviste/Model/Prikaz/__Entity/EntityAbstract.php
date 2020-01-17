<?php
namespace Tester\Model\Request\Entity;


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
    protected $isPersisted = FALSE;    //FALSE;

    /**
     * 
     * @param bool $isPersisted
     */
    public function setPersisted(bool $isPersisted) {
        $this->isPersisted = $isPersisted;
    }
    
    /**
     * 
     * @return bool
     */
    public function isPersisted() {
       
         return $this->isPersisted ;
        //return  $this->isPersisted=='ANO' ?  TRUE :  FALSE;
    }
}
