<?php
namespace Tester\Model\Aggregate\Repository;

use Tester\Model\Db\Repository as  DbRepo;
use Tester\Model\Db\Entity as DbEntity;
use Tester\Model\Aggregate\Entity as AggEntity;
use Tester\Model\Stav\Repository as StavRepo;
use Tester\Model\Stav\Entity as StavEntity;



/**
 * Description of OdpovedAggregate
 *
 * @author vlse2610
 */
class   OdpovedAggregate   implements OdpovedAggregateRepositoryInterface{
    private $repoOdpoved;
    private $repoOdpovedNaOtazku;
    private $repoSessionStav;   
   

    /**
     * 
     * @param \Tester\Model\Db\Repository\Odpoved $repoOdpoved
     * @param \Tester\Model\Db\Repository\OdpovedNaOtazku $repoOdpovedNaOtazku
     */
    public function __construct( DbRepo\Odpoved $repoOdpoved,
                                 DbRepo\OdpovedNaOtazku $repoOdpovedNaOtazku,
                                 StavRepo\StavTestu $repoSessionStav                                                            
                                ) {       
        $this->repoOdpoved = $repoOdpoved;
        $this->repoOdpovedNaOtazku =  $repoOdpovedNaOtazku;
        $this->repoSessionStav = $repoSessionStav;
        
    }

    
    
    private function hydrate(
            AggEntity\OdpovedAggregate $odpovedAggregateE,             
            DbEntity\Odpoved $odpovedE, 
            $odpovediNaOtazkuCol ,       
            StavEntity\SpustenyTest $sessionStavE
            ) {
                    
            $odpovedAggregateE->odpoved = $odpovedE;
            $odpovedAggregateE->odpovediNaOtazky    = $odpovediNaOtazkuCol;
            $odpovedAggregateE->stav = $sessionStavE;                        
            
    }
    
    /**
     * Podle id spusteneho testu najde vsechny odpovedi jiz zapsane do repository. 
     * Vraci objekt OdpovedAggregate.
     * @param type $id
     * @return \Tester\Model\Aggregate\Entity\OdpovedAggregate
     */
    public function get($id){
        $odpovedEntity = $this->repoOdpoved->getByPrubehTestuId($id);                                                
        $odpovediNaOtazkuColl = $this->repoOdpovedNaOtazku->find('id_spusteny_test_fk = :idSpustenyTest', ['idSpustenyTest'=>$id] );
        $sessionSpustenyTestEntity = $this->repoSessionStav->get();
        
        if ($odpovedEntity AND $odpovediNaOtazkuColl ) {                     
            $odpovedAggregateE = new AggEntity\OdpovedAggregate( );
            $this->hydrate($odpovedAggregateE, $odpovedEntity, $odpovediNaOtazkuColl, $sessionSpustenyTestEntity );
            return  $odpovedAggregateE;
        }                
        return ;
    }
    
//    
//    /**
//     * 
//     * Vraci objekt odpoved aggregate kreatovany z pole odpovedi (ziskane z tabbedu) a id spusteneho testu
//     * 
//     * @param array $vsechnyOdpovedi
//     * @param type $idSpustenyTest
//     * 
//     * @return \Tester\Model\Aggregate\Entity\OdpovedAggregate
//     * @throws \UnexpectedValueException
//     */
//    public function create ( array $vsechnyOdpovedi  ) {  
//        $sessionSpustenyTestEntity = $this->repoSessionStav->get();  
//        $idSpustenyTest =  $sessionSpustenyTestEntity->idDbEntityPrubehTestu;
//                
//        if ($vsechnyOdpovedi AND $idSpustenyTest ) {                                   
//            $aa = array();
//            foreach ($vsechnyOdpovedi as $key=>$value) {
//                $odpovedNaOtazku = new DbEntity\OdpovedNaOtazku();  
//                $odpovedNaOtazku->identifikatorOdpovedi = $key ;
//                $odpovedNaOtazku->hodnota = $value ;
//                $odpovedNaOtazku->idSpustenyTestFk = $idSpustenyTest;       
//                $aa[] = $odpovedNaOtazku;
//            }            
//            $odpovediNaOtazkuC = $aa;
//            
//            $odpovedE =  new DbEntity\Odpoved();
//           
//            $odpovedE->idSpustenyTestFk = $idSpustenyTest;
//        
//            $novaOdpovedAggregateE = new AggEntity\OdpovedAggregate;            
//            $this->hydrate( $novaOdpovedAggregateE, $odpovedE, $odpovediNaOtazkuC ,$sessionSpustenyTestEntity );                               
//        
//        return $novaOdpovedAggregateE; 
//        }             
//        else {
//             throw new \UnexpectedValueException( "Neplatné vstupní parametry (vsechnyOdpovedi)." );
//        }                    
//    }
//    
//    
// 
    
    /**
     *  @param \Tester\Model\Aggregate\Entity\OdpovedAggregate $odpovedAggEntity
     */
    public function add ( AggEntity\OdpovedAggregate $odpovedAggEntity ) {                          
//        if ($odpovedAggEntity->stav->testUkoncen) {  TADY NE
//            throw new \LogicException( "Voláte ukládání odpovedi do repository a test je stav-ukoncen." );
//        }
//        else {
            //-odpoved    
            $this->repoOdpoved->add($odpovedAggEntity->odpoved);

            //-odpovediNaOtazky      
            foreach ( $odpovedAggEntity->odpovediNaOtazky as $odpovedNaOtazkuE ){

                $odpovedNaOtazkuE->idPrubehTestuFk = $odpovedAggEntity->odpoved->idPrubehTestuFk;
                $this->repoOdpovedNaOtazku->add($odpovedNaOtazkuE);
            }  

            //a tady do session 
            $this->repoSessionStav->add($odpovedAggEntity->stav);              
//        }
        
    }
    
    
}
