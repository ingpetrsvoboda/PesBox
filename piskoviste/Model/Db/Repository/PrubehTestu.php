<?php
namespace Tester\Model\Db\Repository;

use Tester\Model\Db\Entity\EntityInterface;
use Tester\Model\Db\Entity\PrubehTestu as Entity;

/**
 * Description of PrubehTestu
 *
 * @author vlse2610
 */
class PrubehTestu extends RepositoryAbstract {
       
    /**
     * Nenajde-li, vrací NULL.
     * @param type $id
     * @return Entity
     */
    public function get( $id ) {        //podle primarniho klice       
        $sqlQuery = "SELECT  id_prubeh_testu, 
                          identifikator_ticketu_fk,
                          identifikator_konfigurace_testu_fk,
                          cas_spusteni, 
                          pole_navic
                     FROM prubeh_testu                 
                     WHERE  id_prubeh_testu = :id";                       
        $entity = $this->selectEntity($sqlQuery, array('id'=>$id), Entity::class);
        return $entity;
    }
    
    /**
     *
     * @param type $sqlTemplateWhere
     * @param array $poleNahrad
     * @return Entity array of 
     */
    public function find( $sqlTemplateWhere, array $poleNahrad ) {
        $sqlQuery = "SELECT  id_prubeh_testu, 
                          identifikator_ticketu_fk,
                          identifikator_konfigurace_testu_fk,
                          cas_spusteni, 
                          pole_navic
                    FROM prubeh_testu". ($sqlTemplateWhere ? ' WHERE '.$sqlTemplateWhere : '');

        $entities = $this->selectCollection($sqlQuery, $poleNahrad, Entity::class); 
                        // Entity::class - jazykovy konstrukt tj.string oznacujici jmeno classy
        return $entities;
    }  
     
    
    /**
     * {@inheritdoc}    
     * @param EntityInterface $entity
     */
    public function add(EntityInterface $entity ) {
        if ( $entity->isPersisted()) {
            $sqlQuery = "UPDATE prubeh_testu SET "
                   . "identifikator_ticketu_fk = :identifikatorTicketuFk, "
                   . "identifikator_konfigurace_testu_fk = :identifikatorKonfiguraceTestuFk, "
                   . "cas_spusteni = :casSpusteni, "                   
                   . "pole_navic = :poleNavic "
                   . "WHERE uid_prubeh_testu = :uidPrubehTestu"; 
//                   . "WHERE id_prubeh_testu = :idPrubehTestu";
            $this->update($sqlQuery, $entity);
        } else {
            $sqlQuery = "INSERT INTO prubeh_testu                                                
                              ( identifikator_ticketu_fk,  identifikator_konfigurace_testu_fk, 
                                cas_spusteni,  pole_navic ) 
                      VALUES  ( :identifikatorTicketuFk, :identifikatorKonfiguraceTestuFk,                                   
                                :casSpusteni,  :poleNavic )" ;   
            $this->insert($sqlQuery, $entity);             
        }  
    }
    
   
    

    /**
     * 
     * @param EntityInterface $entity
     */ 
    public function remove(EntityInterface $entity) {
        $sqlQuery = "DELETE FROM prubeh_testu "
                  . "WHERE id_prubeh_testu = :idPrubehTestu";
        $this->destroy($sqlQuery, $entity);
    }  
    
    public function removeAll(){        
        $sqlQuery = "DELETE FROM prubeh_testu "
                  . "WHERE 1=1";                 
        $this->destroyAll($sqlQuery); //vraci null    
        
    }
}
