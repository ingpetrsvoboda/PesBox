<?php

namespace Tester\Model\Db\Repository;

use Tester\Model\Db\Entity\EntityInterface;
use Tester\Model\Db\Entity\SadaOtazek as Entity;

/**
 * Description of KonfiguraceTestu
 *
 * @author vlse2610
 */
class SadaOtazek  extends RepositoryAbstract {
     
    /**
     * Nenajde-li, vrací NULL.
     * 
     * @param mixed $id
     * @return Entity
     */
    public function get( $id ) {        //podle primarniho klice       
        $sqlQuery = "SELECT  * 
                     FROM sada_otazek                 
                     WHERE  id_sada_otazek = :id";                       
        $entity = $this->selectEntity($sqlQuery, array('id'=>$id), Entity::class);
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
                     FROM sada_otazek". ($sqlTemplateWhere ? ' WHERE '.$sqlTemplateWhere : '');
             
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
            $sqlQuery = "UPDATE sada_otazek SET "
                      . "nazev_sady = :nazevSady "                                         
                      . "WHERE id_sada_otazek = :idSadaOtazek";
            $this->update($sqlQuery, $entity);
        } else {
            $sqlQuery = "INSERT INTO sada_otazek                                                
                              (nazev_sady) 
                         VALUES  ( :nazevSady )" ;   
            $this->insert($sqlQuery, $entity);             
        }  
    }
    
    
    /**
     * 
     * @param EntityInterface $entity
     */ 
    public function remove(EntityInterface $entity) {
        $sqlQuery = "DELETE FROM sada_otazek "
                  . "WHERE id_sada_otazek = :idSadaOtazek";
        $this->destroy($sqlQuery, $entity);
    }  
    
      public function removeAll(){        
        $sqlQuery = "DELETE FROM sada_otazek "
                  . "WHERE 1=1";                 
        $this->destroyAll($sqlQuery); //vraci null    
        
    }
    
}

