<?php

namespace Tester\Model\Aggregate\Repository;


//use Tester\Model\Prikaz\VstupniPrikazSpust;
//use Tester\Model\Aggregate\EntityFactory\TestAgregateEntityFactory;
use Tester\Model\Aggregate\Entity as AggEntity;

use Tester\Model\Stav\Entity as StavEntity;
use Tester\Model\Db\Entity as DbEntity;

use Tester\Model\Aggregate\Hydrator as AggHydrator;

use Tester\Model\Stav\Repository as StavRepo;
use Tester\Model\Db\Repository as DbRepo;
use Tester\Model\File\Repository as FileRepo;

/**
 * Description of TestAggregate
 *
 * @author vlse2610
 */
class TestAggregate implements TestAggregateRepositoryInterface {

    private    $repoPrubehTestu ;
    private    $repoTicketPouzity ;
    private    $repoKonfiguraceTestu ;
    private    $repoSadaOtazek;
    private    $repoOtazky;
    private    $repoSessionStav ;
    private    $hydrator ;

    public function __construct(     DbRepo\PrubehTestu $repoPrubehTestu,
                                   DbRepo\TicketPouzity $repoTicketPouzity,
                                DbRepo\KonfiguraceTestu $repoKonfiguraceTestu,
                                      DbRepo\SadaOtazek $repoSadaOtazek, 
                                        FileRepo\Ulohy $repoOtazky,
                                     StavRepo\StavTestu $repoSessionStav,
            
                      AggHydrator\TestAggregateHydrator $hydrator) {
                    //$this->container = $container; zde v tomto objektu nema byt kontejner
        $this->repoPrubehTestu = $repoPrubehTestu ;
        $this->repoTicketPouzity = $repoTicketPouzity ;
        $this->repoKonfiguraceTestu = $repoKonfiguraceTestu ;
        $this->repoSadaOtazek = $repoSadaOtazek ;
        $this->repoOtazky = $repoOtazky ;
        $this->repoSessionStav = $repoSessionStav ;  
        
        $this->hydrator = $hydrator;
    }
    

//    /**
//     * PODLE SESSION
//     * Vytvori a vrátí aggregateEntitySpustenyTest entitu..   PODLE SESSION
//     * NEobsahuje entitu vstupniPrikaz ( inicializacni runda) nebo ne (bezna runda).  
//     * Vraci null, kdyz lze zaroven  rekreatovat spusteny test ze session a vstupni prikaz z requestu.
//     * 
//     * @return AggEntity\SpustenyTestAggregate $aggregateEntityST
//     */
    /**
     * 
     *            // @param type $idTestAggregate
     * @return \Tester\Model\Aggregate\Entity\TestAggregate
     * @throws \LogicException
     */
    public function get(  ) {  // $idTestAggregate JE  NEPOUZITE
    
       // if ($sessionEntitySpustenyTest) {
       // MY MAME JEN JEDNO ULOZISTE SESSION/STAV  $idtestAggregate zatim navic???
       ########
            //$prubehTestuE = $this->repoPrubehTestu->get($idTestAggregate); 
       ########
            
            $sessionStavE = $this->repoSessionStav->get();       
            $prubehTestuE = $this->repoPrubehTestu->get($sessionStavE->idDbEntityPrubehTestu);  
            
            
            if ($prubehTestuE) {
                $ticketPouzityE = $this->repoTicketPouzity->get($prubehTestuE->identifikatorTicketuFk); //obj
                $konfiguraceTestuE = $this->repoKonfiguraceTestu->get($prubehTestuE->identifikatorKonfiguraceTestuFk); //obj

                if ($ticketPouzityE AND $konfiguraceTestuE) {
                    $sadaOtazekE = $this->repoSadaOtazek->get($konfiguraceTestuE->idSadaOtazekFk );      

                    $otazkyE = $this->repoOtazky->find($sadaOtazekE->nazevSady);                   

                    $testAggregateE = new AggEntity\TestAggregate();  
//                    $this->hydrator->hydrate($testAggregateE,
//                                $prubehTestuE, $konfiguraceTestuE, $ticketPouzityE,  $sadaOtazekE, $otazkyE,
//                                $sessionStavE/*, NULL*/);
                    $this->hydrate($testAggregateE,
                                $prubehTestuE, $konfiguraceTestuE, $ticketPouzityE,  $sadaOtazekE, $otazkyE,
                                $sessionStavE/*, NULL*/);
                }
            }
            else {
                 throw new \LogicException('Nenalezen prubehTestu.');
            }
            
       // }
        return $testAggregateE;                
    }   
    
 
     

    /**
     * Naplneni hodnot aggregatu po vzyvednuti z uloziste (tj. z tabulek databaze) a ze session

     * @param \Tester\Model\Aggregate\Entity\SpustenyTestAggregate $testAggregateE
     * @param \Tester\Model\Db\Entity\SpustenyTest $spustenyTestE
     * @param \Tester\Model\Db\Entity\KonfiguraceTestu $konfiguraceTestuE
     * @param \Tester\Model\Db\Entity\TicketPouzity $ticketPouzityE
     * @param \Tester\Model\Db\Entity\SadaOtazek $sadaOtazekE
     * @param array $arrayOtazkyC
     * @param Tester\Model\Session\Entity $stavTestu
     * @param Tester\Model\Request\Entity $vstupniPrikaz
     */
    private function hydrate(
                    AggEntity\TestAggregate $testAggregateE, 
                       DbEntity\PrubehTestu $prubehTestuE, 
                  DbEntity\KonfiguraceTestu $konfiguraceTestuE, 
                     DbEntity\TicketPouzity $ticketPouzityE,
                        DbEntity\SadaOtazek $sadaOtazekE,
                                            $arrayOtazkyC,
                       StavEntity\StavTestu $stavTestu
                        /* VstupniPrikazSpust $vstupniPrikaz = NULL*/
            ) {
                    
            $testAggregateE->prubehTestu = $prubehTestuE;
            $testAggregateE->konfiguraceTestu = $konfiguraceTestuE;  
            $testAggregateE->ticketPouzity = $ticketPouzityE;   
            $testAggregateE->sadaOtazek = $sadaOtazekE;                        
            $testAggregateE->ulohy = $arrayOtazkyC;  
            $testAggregateE->stav = $stavTestu;
            
            $testAggregateE->idTestAggregate = $testAggregateE->prubehTestu->idPrubehTestu;
            /*$spustenyTestAggregateE->vstupniPrikaz = $vstupniPrikaz;*/
            
    }
    
    
public function add (AggEntity\TestAggregate $aggTestEntity ){    
            //do ticket pouzity
        $this->repoTicketPouzity->add($aggTestEntity->ticketPouzity);
            
            //do prubeh testu
        $aggTestEntity->prubehTestu->identifikatorKonfiguraceTestuFk = $aggTestEntity->konfiguraceTestu->uidKonfiguraceTestu;
        
        $aggTestEntity->prubehTestu->identifikatorTicketuFk = $aggTestEntity->ticketPouzity->identifikatorTicketu;
        $this->repoPrubehTestu->add($aggTestEntity->prubehTestu);            
            //kde/y se do  $entity->prubeh_testu dostane id prubeh testu  --  pri ulozeni do tabulky
            //   
            //a tady do session
        $aggTestEntity->stav->idDbEntityPrubehTestu = $aggTestEntity->prubehTestu->idPrubehTestu;
        $this->repoSessionStav->add($aggTestEntity->stav);
        
        $aggTestEntity->idTestAggregate = $aggTestEntity->prubehTestu->idPrubehTestu;
      
        
    }     
    
    //---------------------------------------------------------------------------------------------------------------
    
//    /**
//     * Zapisuje vlastnosti jednotlivych jiz naplnenych objektu  a doplni vzajemne vazby (id-cka).
//     * 
//     * @param Tester\Model\Aggregate\Entity\TestAggregate $aggTestEntity
//     */
//    private function add1 ( AggEntity\TestAggregate $aggTestEntity ){    
//            //do ticket pouzity
//        /* @var $repoTicket DbRepo\TicketPouzity */ 
//        $repoTicket = $this->container->get( DbRepo\TicketPouzity::class );
//        $repoTicket->add($aggTestEntity->ticketPouzity);
//        //$this->repoTicketPouzity->add($aggSpustTestEntity->ticketPouzity);
//            
//            //do prubeh  testu
//        //$aggSpustTestEntity->prubehTestu->identifikatorKonfiguraceTestuFk = $aggSpustTestEntity->konfiguraceTestu->idKonfiguraceTestu;
//                    //tam je uz z  $testAgregateEntityFactory-createByPrikaz...
//        $aggTestEntity->prubehTestu->identifikatorTicketuFk = $aggTestEntity->ticketPouzity->identifikatorTicketu;
//        /* @var $repoPrubehTestu  DbRepo\PrubehTestu */ 
//        $repoPrubehTestu = $this->container->get( DbRepo\PrubehTestu::class);
//        $repoPrubehTestu->add( $aggTestEntity->prubehTestu);
//        //$this->repoSpustenyTest->add($aggSpustTestEntity->prubehTestu);            
//            //kde/y se do  $entity->prubeh_testu dostane id prubeh testu  --  pri ulozeni do tabulky
//            
//        $aggTestEntity->idTestAggregate = $aggTestEntity->prubehTestu->idPrubehTestu;
//            //a tady do (session) stavu
//        $aggTestEntity->stav->idDbEntityPrubehTestu = $aggTestEntity->prubehTestu->idPrubehTestu;
//         /* @var $sessionRepoSpustenyTest StavRepo\StavTestu */
//        $sessionRepoSpustenyTest = $this->container->get(StavRepo\StavTestu::class);
//        $sessionRepoSpustenyTest->add($aggTestEntity->stav); 
        
// tady - místo tohohle:
//        $this->sessionRepoSpustenyTest->add($aggSpustTestEntity->stav);
// bude tojlencto - prptoža máme kontejner!!        
//        /* @var $sessionRepoSpustenyTest StavRepo\StavTestu */
//        $sessionRepoSpustenyTest = $this->container->get(StavRepo\StavTestu::class);
//        $sessionRepoSpustenyTest->add($aggSpustTestEntity->stav);             
//} 
    
    
//     private function extract(
//            Entity $spustenyTestAggregateE, 
//            DbEntity\SpustenyTest $spustenyTestE, 
//            DbEntity\TicketPouzity $ticketPouzityE) {         
//        $spustenyTestAggregateE->spusteny_test->idTicketPouzityFk = $ticketPouzityE->idTicketPouzity;
//        $spustenyTestAggregateE->spusteny_test->identifikatorKonfiguraceTestuFk = $konfiguraceTestuE->idKonfiguraceTestu;
//    }
    
}
