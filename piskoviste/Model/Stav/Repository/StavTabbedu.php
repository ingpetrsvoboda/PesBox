<?php
namespace Tester\Model\Stav\Repository;

//e Tester\Model\Handler\SessionInterface;
use Tester\Model\Stav\Entity\StavTabbedu ;
use Pes\Session\SessionHandlerInterface;


/**
 * Description of StavTestu
 *
 * @author vlse2610
 */
class StavTabbedu implements RepositoryInterface {
    
    const TABBED_CONTAINER = '_Tabbed_container';

    private $sessionHandler;    
   
    /**
     * @var Tester\Model\Stav\Entity\StavTabbedu 
     */
    private $stavTabbedu; 
    
    public function __construct( SessionHandlerInterface $sessionHandler ) {
        
        $this->sessionHandler = $sessionHandler;                    
    }
        
    /**
     * Vrací entitu StavTabbedu
     * @return StavTabbedu
     */
    public function get() {
        if( $this->sessionHandler->get(self::TABBED_CONTAINER) ) {              
            $entity = new StavTabbedu();
            $entity->tabbedContainer = serialize($sessionHandler->get(self::TABBED_CONTAINER));
            $entity->setPersisted(TRUE);
        }
        return $entity ?? NULL;  
    }
    
    /**
     * Přidá entitu StavTabbedu do repository. Pokud již entita v repository je, přepíše ji novou entitou.
     * @param StavTabbedu $stavTabbedu
     */
    public function add(StavTabbedu $stavTabbedu ){
        $this->sessionHandler->set(self::TABBED_CONTAINER, unserialize($stavTabbedu->tabbedContainer));            
        $stavTabbedu->setPersisted( TRUE);  // nastaveni do entity ///  
        
    }
    
    /**
     * Smaže entitu StavTabbedu
     * @param StavTabbedu $stavTabbedu
     */
    public function remove(StavTabbedu $stavTabbedu ) {
        $this->sessionHandler->set(self::TABBED_CONTAINER, null); // nastaveni do session
        $stavEntity->setPersisted(FALSE);  // nastaveni do entity 
    }
    
}
