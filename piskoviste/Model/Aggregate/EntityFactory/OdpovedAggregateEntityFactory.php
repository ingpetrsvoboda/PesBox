<?php
namespace Tester\Model\Aggregate\EntityFactory;
 
use Tester\Model\Aggregate\Entity\OdpovedAggregate;

use Tester\Model\Stav\Repository\StavTestu;
use Tester\Model\Db\Entity as DbEntity;

/**
 * Description of OdpovedAggregateEntityFactory
 *
 * @author vlse2610
 */
class OdpovedAggregateEntityFactory implements OdpovedAgregateEntityFactoryInterface {

    public $repoStav;     


    public function __construct(     StavTestu $repoStav
                                    /*TestAggregateHydrator $hydrator */   ) {             
         $this->repoStav = $repoStav;         
         //$this->hydrator = $hydrator;     
    }
  
    
    /**
     * 
     * Vytvori objekt odpoved aggregate s odpovedmi zadanymi uzivatelem v testu (ziskane z tabbedu) a id spusteneho testu (ze sessionStav ).
     * 
     * @param array $vsechnyOdpovedi
     * 
     * @return Tester\Model\Aggregate\Entity\OdpovedAggregate $novaOdpovedAggregateE
     * @throws \UnexpectedValueException
     */
    public function createSOdpovedmi ( array $vsechnyOdpovedi  )  : OdpovedAggregate 
    {          
        $sessionStavEntity = $this->repoStav->get();  
        $idPrubehTestu =  $sessionStavEntity->idDbEntityPrubehTestu;
                
        if ($vsechnyOdpovedi AND $idPrubehTestu ) {                                   
            $odpovediNaOtazkuCol = array();
            //v key jsou identifikatory
            foreach ($vsechnyOdpovedi as $key=>$value) { 
                $odpovedNaOtazku = new DbEntity\OdpovedNaOtazku();  
                $odpovedNaOtazku->identifikatorOdpovedi = $key ;
                $odpovedNaOtazku->hodnota = $value ;
                $odpovedNaOtazku->idPrubehTestuFk = $idPrubehTestu;       
                $odpovediNaOtazkuCol[] = $odpovedNaOtazku;
            }                      
            
            $odpovedE =  new DbEntity\Odpoved();           
            $odpovedE->idPrubehTestuFk = $idPrubehTestu;
        
            $novaOdpovedAggregateE = new OdpovedAggregate();                
            // hydrate         
            $novaOdpovedAggregateE->stav =  $sessionStavEntity; 
            $novaOdpovedAggregateE->odpoved = $odpovedE;
            $novaOdpovedAggregateE->odpovediNaOtazky = $odpovediNaOtazkuCol;
            
            
            
            //$novaOdpovedAggregateE->idOdpovedAggregate =  $novaOdpovedAggregateE->odpoved->idOdpoved; //tady asi nic neni !!??                        
            //$this->hydrate( $novaOdpovedAggregateE, $odpovedE, $odpovediNaOtazkuC ,$stavE );                               
        
        return $novaOdpovedAggregateE; 
        }             
        else {
             throw new \UnexpectedValueException( "Neplatné vstupní parametry (vsechnyOdpovedi/idPrubehTestu)." );
        }                    
    }
    
    
 
    
}
