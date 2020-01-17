<?php
namespace Tester\Model\Aggregate\EntityFactory;

use Tester\Model\Aggregate\EntityFactory\TestAgregateEntityFactoryInterface;
use Tester\Model\Prikaz\VstupniPrikazSpust;
use Tester\Model\Prikaz\VstupniPrikazUkaz;

use Tester\Model\Aggregate\Entity as AggEntity;
use Tester\Model\Db\Entity as DbEntity;
use Tester\Model\Stav\Entity as StavEntity;

use Tester\Model\Db\Repository\PrubehTestu;
use Tester\Model\Db\Repository\KonfiguraceTestu;
use Tester\Model\Db\Repository\SadaOtazek;
use Tester\Model\File\Repository\Ulohy ;
use Tester\Model\Db\Repository\TicketPouzity;
use Tester\Model\Stav\Repository\StavTestu;

use Tester\Model\Aggregate\Hydrator\TestAggregateHydrator;

/**
 * Description of SpustenyTestAgregateEntityFactory
 *
 * @author vlse2610
 */
class TestAgregateEntityFactory implements TestAgregateEntityFactoryInterface {
           
    private $repoPrubehTestu;       
    private $repoKonfiguraceTestu;            
    private $repoSadaOtazek ;
    private $repoOtazky; 
    private $repoTicketPouzity;
    private $repoStav;
    private $hydrator;
    
    public function __construct(              
                                       PrubehTestu $repoPrubehTestu,             
                                  KonfiguraceTestu $repoKonfiguraceTestu,
                                        SadaOtazek $repoSadaOtazek,
                                            Ulohy $repoOtazky,
                                     TicketPouzity $repoTicketPouzity,
                                         StavTestu $repoStav,
             
                             TestAggregateHydrator $hydrator    ) {
         
        
         $this->repoPrubehTestu = $repoPrubehTestu;
         $this->repoKonfiguraceTestu = $repoKonfiguraceTestu;   
         $this->repoSadaOtazek = $repoSadaOtazek;
         $this->repoOtazky = $repoOtazky;          
         $this->repoTicketPouzity = $repoTicketPouzity;
         $this->repoStav = $repoStav;
         
         $this->hydrator = $hydrator;     
    }
    
    
    
    /**
     * Vyrobi NOVY objekt entity SpustenyTestAggregate entity.
     * A naplni ho hodnotami 'podle/z' objektu VstupniPrikaz
     * 
     * @param Tester\Model\Prikaz\VstupniPrikazSpust\VstupniPrikazSpust $vstupniPrikazSpust
     * @return \Tester\Model\Aggregate\Entity\TestAggregate
     * @throws \UnexpectedValueException
     */                    
    public function createByPrikazSpust( VstupniPrikazSpust $vstupniPrikazSpust )  : AggEntity\TestAggregate  {
            // podle uidentifikatorKonfiguraceTestu ze VstupniPrikaz vybere konfiguraci testu
            $konfiguraceTestuE  = $this->repoKonfiguraceTestu->get($vstupniPrikazSpust->uidKonfiguraceTestu);   //$uidKonfiguraceTestu
            if (!isset($konfiguraceTestuE)) {
                throw new \UnexpectedValueException("Neexistuje zadaná konfigurace testu. Zadáno uid: $vstupniPrikazSpust->uidKonfiguraceTestu.");
            }
            $sadaOtazekE = $this->repoSadaOtazek->get($konfiguraceTestuE->idSadaOtazekFk);        
            $arrayUlohyC = $this->repoOtazky->find($sadaOtazekE->nazevSady);
            
            //vyrobi novy obj. Spusteny test
            $prubehTestuE =  new DbEntity\PrubehTestu();
//$prubehTestuE->identifikatorKonfiguraceTestuFk = $konfiguraceTestuE->idKonfiguraceTestu;
            //vyrobi novy obj. Ticket Pouzity a zapise do neho identifikatorTicketu ze Vstupniho prikazu
            $ticketPouzityE = new DbEntity\TicketPouzity();
            $ticketPouzityE->identifikatorTicketu = $vstupniPrikazSpust->identifikatorTicketu;           
            //vyrobi novy obj. Session spusteny test
            $stav = new StavEntity\StavTestu();

            //vyrobi a sestavi novy aggregate entity Spusteny test aggregate
            $spustenyTestAggregateE = new AggEntity\TestAggregate();              
            
            //$spustenyTestAggregateE = $prubehTestuE->idPrubehTestu;   //asi navic, asi tam nic neni !!!zadne id spusteny test neni v teto chvili pritomno
            
            $spustenyTestAggregateE->konfiguraceTestu = $konfiguraceTestuE ;
            $spustenyTestAggregateE->ticketPouzity =  $ticketPouzityE  ;
            $spustenyTestAggregateE->prubehTestu =  $prubehTestuE   ;       
            $spustenyTestAggregateE->sadaOtazek = $sadaOtazekE  ;
            $spustenyTestAggregateE->ulohy = $arrayUlohyC  ;
            $spustenyTestAggregateE->stav = $stav  ;
                      
//            $this->hydrator->hydrate( $spustenyTestAggregateE, $spustenyTestAggregateE->konfiguraceTestu,  $konfiguraceTestuE );
//            $this->hydrator->hydrate( $spustenyTestAggregateE, $spustenyTestAggregateE->ticketPouzity,   $ticketPouzityE  );
//            $this->hydrator->hydrate( $spustenyTestAggregateE, $spustenyTestAggregateE->spustenyTest,   $spustenyTestE   );       
//            $this->hydrator->hydrate( $spustenyTestAggregateE, $spustenyTestAggregateE->sadaOtazek, $sadaOtazekE  );
//            $this->hydrator->hydrate( $spustenyTestAggregateE, $spustenyTestAggregateE->otazky, $arrayOtazkyC  );
//            $this->hydrator->hydrate( $spustenyTestAggregateE, $spustenyTestAggregateE->sessionSpustenyTest, $sessionSpustenyTestE  );
     
//            foreach ( $spustenyTestAggregateE as $key=>$value){
//                $this->hydrator->hydrate( $key, $value );
//            }       
//            $this->hydrator->hydrate($spustenyTestAggregateE, $spustenyTestE, $konfiguraceTestuE, $ticketPouzityE,
//                                     $sadaOtazekE, $arrayOtazkyC, $sessionSpustenyTest);                   
            
            return $spustenyTestAggregateE;  
    }
    
    public function createByPrikazUkaz( VstupniPrikazUkaz $vstupniPrikazUkaz)  : AggEntity\TestAggregate {
       
        $prubehTestuE = $this->repoPrubehTestu->get($vstupniPrikazUkaz->idPrubehTestu);        
        $konfiguraceTestuE = $this->repoKonfiguraceTestu->get( $prubehTestuE->identifikatorKonfiguraceTestuFk);                
        $ticketPouzityE = $this->repoTicketPouzity->getByIdentifikatorTicketu($prubehTestuE->identifikatorTicketuFk);

        $sadaOtazekE = $this->repoSadaOtazek->get($konfiguraceTestuE->idSadaOtazekFk);        
        $arrayOtazkyC = $this->repoOtazky->find($sadaOtazekE->nazevSady); 
        $stavE = $this->repoStav->get();
                
        //vyrobi a sestavi novy aggregate entity Spusteny test aggregate
        $spustenyTestAggregateE = new AggEntity\TestAggregate(); 
        
        $spustenyTestAggregateE->prubehTestu = $prubehTestuE;
        $spustenyTestAggregateE->idTestAggregate = $prubehTestuE->idPrubehTestu;  //!!!
        $spustenyTestAggregateE->konfiguraceTestu = $konfiguraceTestuE;
        $spustenyTestAggregateE->ticketPouzity = $ticketPouzityE;
        $spustenyTestAggregateE->sadaOtazek = $sadaOtazekE;
        $spustenyTestAggregateE->ulohy = $arrayOtazkyC;        
        $spustenyTestAggregateE->stav = $stavE;
    
        return $spustenyTestAggregateE;  
        
    }
}



//     private function hydrate(
//            AggEntity\SpustenyTestAggregate $spustenyTestAggregateE, 
//                      DbEntity\SpustenyTest $spustenyTestE, 
//                  DbEntity\KonfiguraceTestu $konfiguraceTestuE, 
//                     DbEntity\TicketPouzity $ticketPouzityE,
//                        DbEntity\SadaOtazek $sadaOtazekE,
//                                            $arrayOtazkyC,
//                 SessionEntity\SpustenyTest $sessionSpustenyTest
//                         //VstupniPrikazSpust $vstupniPrikaz = NULL
//            ) {
//                    
//            $spustenyTestAggregateE->spustenyTest = $spustenyTestE;
//            $spustenyTestAggregateE->konfiguraceTestu = $konfiguraceTestuE;  
//            $spustenyTestAggregateE->ticketPouzity = $ticketPouzityE;   
//            $spustenyTestAggregateE->sadaOtazek = $sadaOtazekE;                        
//            $spustenyTestAggregateE->otazky = $arrayOtazkyC;  
//            $spustenyTestAggregateE->sessionSpustenyTest = $sessionSpustenyTest;
//            $spustenyTestAggregateE->vstupniPrikaz = $vstupniPrikaz;
//            
//    }
    

