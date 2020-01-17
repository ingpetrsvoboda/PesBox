<?php

namespace Tester\Model\Db\Repository;

use Tester\Model\Db\Entity\EntityInterface;
use Tester\Model\Db\Entity\KonfiguraceTestu as Entity;

/**
 * Description of KonfiguraceTestu
 *
 * @author vlse2610
 */
class KonfiguraceTestu  extends RepositoryAbstract {
        
    /**
     * 
     * @param string $uid
     * @return Entity
     */
    public function get( $uid ) {        //podle uid klice       
        $sqlQuery = "SELECT  * 
                     FROM konfigurace_testu                 
                     WHERE  uid_konfigurace_testu = :uidKonfiguraceTestu";                       
        $entity = $this->selectEntity($sqlQuery, array('uidKonfiguraceTestu'=>$uid), Entity::class);
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
                     FROM konfigurace_testu". ($sqlTemplateWhere ? ' WHERE '.$sqlTemplateWhere : '');
             
        $entities = $this->selectCollection($sqlQuery, $poleNahrad, Entity::class); 
        // Entity::class - jazykovy konstrukt tj.string oznacujici jmeno classy
        return $entities;
    }  
    
    
    
    
    

    
    
    /**
     * {@inheritdoc}   
     * @param EntityInterface $entity
     */
    public function add( EntityInterface $entity ) {                
        
        if ( $entity->isPersisted()) {
            $sqlQuery = "UPDATE konfigurace_testu SET "
                      . "popis_testu = :popisTestu, "
                      . "nazev_testu = :nazevTestu, "
                      . "paralel_v_session_spustitelny = :paralelVSsessionSpustitelny, "                    
                      . "id_sada_otazek_fk = :idSadaOtazekFk, "
                      . "valid = :valid "                      
                      . "WHERE uid_konfigurace_testu = :uidKonfiguraceTestu";
            $this->update($sqlQuery, $entity);
        } else {
           
            $sqlQuery = "INSERT INTO konfigurace_testu                                                
                              ( uid_konfigurace_testu, popis_testu,  nazev_testu, vicekrat_spustitelny, paralel_v_session_spustitelny
                                id_sada_otazek_fk, valid) 
                         VALUES  ( :uidKonfiguraceTestu, :popisTestu, :nazevTestu, :vicekratSpustitelny, :paralelVSsessionSpustitelny                                
                                   :idSadaOtazekFk, :valid )" ;   
            $this->insertWithUid($sqlQuery, $entity, 'uidKonfiguraceTestu');                
        }  
    }
    
    
    /**
     * 
     * @param EntityInterface $entity
     */ 
    public function  remove(EntityInterface $entity) {
        $sqlQuery = "DELETE FROM konfigurace_testu "
                  . "WHERE uid_konfigurace_testu = :uidKonfiguraceTestu";
        //$sqlQuery = "DELETE FROM konfigurace_testu "
        //          . "WHERE id_konfigurace_testu = :idKonfiguraceTestu";
       
        $this->destroy($sqlQuery, $entity); //vraci null     
    }  
    
    
      public function removeAll(){        
        $sqlQuery = "DELETE FROM konfigurace_testu "
                  . "WHERE 1=1";                 
        $this->destroyAll($sqlQuery); //vraci null    
        
    }
    
}
