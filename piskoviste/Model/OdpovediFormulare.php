<?php
namespace Tester\Model;

use Tester_Tabbed_Controller_Page_Populator_RadioGroupPopulator;

/**
 * Odpovedi jedne osoby.
 *
 * @author vlse2610
 */
class OdpovediFormulare implements OdpovediFormulareInterface {

    /**
     *
     * @var Tester_Tabbed_Controller_Page_Populator_RadioGroupPopulator 
     */
    private $pageAutomat;
    
    /**
     * 
     * @param Tester_Tabbed_Controller_Page_Populator_RadioGroupPopulator $pageAutomat
     */
    public function __construct(Tester_Tabbed_Controller_Page_Populator_RadioGroupPopulator $pageAutomat) {
        $this->pageAutomat = $pageAutomat;                
    }
    
    /**
     * Vrací pole s odpověďmi zadanými v testu. Jméno prvku pole je vlastnost name z radiobuttonu formulare (?zda se).
     * @return array ve tvaru:  pole['uloha01'] = '03'
     */
    public function getOdpovedi() {
        return $this->pageAutomat->getController()->getValue(); 
    }    
            
}
