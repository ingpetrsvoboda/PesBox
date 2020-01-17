<?php
namespace Tester\Model\Stav\Repository;

//e Tester\Model\Handler\SessionInterface;
use Tester\Model\Stav\Entity as StavEntity ;
use Pes\Session\SessionStatusHandlerInterface;


/**
 * Description of StavTestu
 *
 * @author vlse2610
 */
class StavTestu implements RepositoryInterface {

    const NAME_PERSISTED      =  'persisted';
   // const NAME_TESTUKONCEN    =  'testUkoncen';

    private $sessionHandler;


    public function __construct( SessionStatusHandlerInterface $sessionHandler ) {

        $this->sessionHandler = $sessionHandler;
    }

    /**
     * Z uloziste v session   vyzvedne ulozene (napr. id prubehu testu, a ostatni vlastnosti) a znovuvytvori objekt
     * (pozn. pro trdla - vytvori pro tento beh skriptu  novy objekt)  typu  Tester\Model\Stav\Entity\Stav.
     * (Vlastnosti neulozene naplni null, vlastnosti s hodnotou false naplni false.)
     * Nema-li z ceho vytvorit (neni nstavena promenna 'persisted'), vraci NULL.
     *
     * @return StavEntity\StavTestu
     */
    public function get() {
        ######## nemame vice id v session
        ####### MY MAME JEN JEDNO ULOZISTE SESSION/STAV
        #######

        if( $this->sessionHandler->get(self::NAME_PERSISTED) ) {

            $entity = new StavEntity\StavTestu();
            foreach ($entity as $key => $value) {
                //if ( $this->sessionHandler->has($key) ) {
                    $entity->$key = $this->sessionHandler->get($key);
                //}
                $entity->setPersisted(TRUE);

            }
        }
        return $entity ?? NULL;
    }

    /**
     * Do uloziste v session  -   ulozi  vlastnosti stav prubeh testu (napr.$idDbEntityPrubehTestu, testUkoncen).
     *
     * @param  $stavEntity
     */
    public function add( StavEntity\StavTestu $stavEntity ){
        foreach ($stavEntity as $key => $value) {
            $this->sessionHandler->set($key, $value);
        }

        $this->sessionHandler->set(self::NAME_PERSISTED, TRUE);  //nastaveni persisted do session

        $stavEntity->setPersisted( TRUE);  // nastaveni do entity ///

    }




    /**
     * Z uloziste v session  odstraní chlivecek persisted.
     * To znamena, ze entita v session "neni".
     */
    public function remove( StavEntity\StavTestu $stavEntity ) {
        $this->sessionHandler->set(self::NAME_PERSISTED, null); // nastaveni do session
        $stavEntity->setPersisted(FALSE);  // nastaveni do entity
    }

}
