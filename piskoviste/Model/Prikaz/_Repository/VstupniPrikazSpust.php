<?php
namespace Tester\Model\Request\Repository;

use Tester\Model\Request\Entity\VstupniPrikazSpust;

use Pes\Http\RequestInterface;
use Tester\Validator\Request as Validator;

/**
 * Description of VstupniPrikaz
 *
 * @author vlse2610
 */
class VstupniPrikazSpust implements RepositoryInterface {
    
    private $request;
    
    
    public function __construct( RequestInterface $request ) {
        
        $this->request = $request;        
    }

    
    /**
     * Z "uloziste ve vstupni radce-prikazu" tj.v requestu -  vyzvedne uid konfigurace testu a id ticketu a vytvori objekt Vstupni Prikaz.
     * Pokud ovšem  ve vstupním příkazu chybi parametr(y),  vraci NULL.
     * typu  Tester\Model\Request\Entity\VstupniPrikaz
     *
     * @return Tester\Model\Request\Entity\VstupniPrikazSpust
     */
    public function getNovyVstupniPrikaz( ) {    
        
        if ((new Validator\InicializacniSpustTestRequest())->isValid( $this->request ) )
        {
            $entity = new VstupniPrikazSpust();           
            foreach ($entity as $key => $value) {
                $entity->$key = $this->request->getParam( $key );                   
            }             
            $entity->setPersisted(TRUE);                
        return $entity;  
        
        }
        //else return ;
    }
    
//    
//            
//    /**
//     * Vrací označení ticketu z GET promenne nebo NULL.
//     */
//    private function dejIdentifikatorTicketuZGET() : string {    
//         $identifikatorTicketu = $this->request->getParam(self::PARAM_GET_IDENT_TICKETU); 
//         return isset($identifikatorTicketu) ? $identifikatorTicketu : NULL  ;
//    }
//    
//    
//    /**
//     * Vrací označení konfigurace testu z GET promenne nebo NULL.
//     */
//    private function dejIdentifikatorKonfiguraceTestuZGET()  : string {    
//         $identifikatorTestu = $this->request->getParam(self::PARAM_GET_IDENT_KONFIGURACE_TESTU); 
//         return isset($identifikatorTestu) ? $identifikatorTestu : NULL  ;
//    }
    
    
    
    
}
