<?php
namespace Tester\Model\Stav\Entity;

use Tester\Model\Stav\Entity\EntityAbstract;


/**
 * Description of SpustenyTest
 *
 * @author vlse2610
 */
class StavTestu extends EntityAbstract {
    
    // zde by teoreticky melo byt id teto entity pro identifikaci a pro rozhodovani zda insert nebo update
    // ale protoze mame jen jednu entitu, a vzdycky se zapisuje 'stejne' , tak tu vlastnost id teto entity neni    
    //public $idStavTestu;
    
    
    /**
     * uchovavana informace o ('spustenem' probihajicim) prubehu testu - id prubeh testu
     */
    public $idDbEntityPrubehTestu;        
    
    public $testUkoncen;
    
    public $testZahajen;
    

    
}
