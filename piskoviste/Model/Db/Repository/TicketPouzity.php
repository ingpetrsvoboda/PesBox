<?php

namespace Tester\Model\Db\Repository;

use Tester\Model\Db\Entity\EntityInterface;
use Tester\Model\Db\Entity\TicketPouzity as Entity;

/**
 * Description of KonfiguraceTestu
 *
 * @author vlse2610
 */
class TicketPouzity  extends RepositoryAbstract {
     
    /**
     * Nenajde-li, vrací NULL.
     * 
     * @param mixed $id
     * @return Entity
     */
    public function get( $id ) {        //podle primarniho klice       
        $sqlQuery = "SELECT  * 
                     FROM ticket_pouzity                 
                     WHERE  identifikator_ticketu = :id";                       
        $entity = $this->selectEntity($sqlQuery, array('id'=>$id), Entity::class);
        return $entity;
    }
    
    /**
     * 
     * @param string $identifikatorTicketu
     * @return Entity
     */
    public function getByIdentifikatorTicketu( $identifikatorTicketu ) {        //podle primarniho klice       
        $sqlQuery = "SELECT  * 
                     FROM ticket_pouzity                 
                     WHERE  identifikator_ticketu = :identifikatorTicketu";                       
        $entity = $this->selectEntity($sqlQuery, array('identifikatorTicketu'=>$identifikatorTicketu), Entity::class);
        return $entity;
    }    
    
    /**
     * 
     * @param string $sqlTemplateWhere
     * @param array $poleNahrad
     * @return Entity array of
     */     
    public function find( $sqlTemplateWhere, array $poleNahrad ) {
        $sqlQuery = "SELECT  *
                     FROM ticket_pouzity". ($sqlTemplateWhere ? ' WHERE '.$sqlTemplateWhere : '');
             
        $entities = $this->selectCollection($sqlQuery, $poleNahrad, Entity::class); 
        // Entity::class - jazykovy konstrukt tj.string oznacujici jmeno classy
        return $entities;
    }  
    
    
    /**
     * {@inheritdoc}
     * @param EntityInterface $entity
     */
    public function add( EntityInterface $entity ) {
        
        if ( $entity->isPersisted()) {    // zjisteni kvuli update - trochu je  to hloupost 
            $sqlQuery = "UPDATE ticket_pouzity SET "                    
                      . "identifikator_ticketu = :identifikatorTicketu "                                           
                      . "WHERE identifikator_ticketu = :identifikatorTicketu";
            $this->update($sqlQuery, $entity);
        } else {
            $sqlQuery = "INSERT INTO ticket_pouzity                
                              ( identifikator_ticketu) 
                         VALUES  ( :identifikatorTicketu)" ;   
            $this->insert($sqlQuery, $entity);             
        }  
    }
    
    
    /**
     * 
     * @param EntityInterface $entity
     */ 
    public function remove(EntityInterface $entity) {
        $sqlQuery = "DELETE FROM ticket_pouzity "
                  . "WHERE identifikator_ticketu = :identifikatorTicketu";
        $this->destroy($sqlQuery, $entity);
    }  
    
    
      public function removeAll(){        
        $sqlQuery = "DELETE FROM ticket_pouzity "
                  . "WHERE 1=1";                 
        $this->destroyAll($sqlQuery); //vraci null    
        
    }
    
}
