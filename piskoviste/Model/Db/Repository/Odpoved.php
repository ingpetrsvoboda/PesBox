<?php

namespace Tester\Model\Db\Repository;


use Tester\Model\Db\Entity\EntityInterface;
use Tester\Model\Db\Entity\Odpoved as Entity;

/**
 * Description of Odpoved
 *
 * @author vlse2610
 */
class Odpoved extends RepositoryAbstract implements OdpovedInterface {
    
    /**
     * Nenajde-li, vrací NULL.
     * 
     * @param mixed $id
     * @return Entity
     */
    public function get( $id) {            
        $sqlQuery = "SELECT  * 
                     FROM odpoved                 
                     WHERE  id_odpoved = :id";                       
        $entity = $this->selectEntity($sqlQuery, array('id'=>$id), Entity::class);
        return $entity;    
    }
    

    public function getByPrubehTestuId( $idST) {            
        $sqlQuery = "SELECT  * 
                     FROM odpoved                 
                     WHERE  id_prubeh_testu_fk = :id";                       
        $entity = $this->selectEntity($sqlQuery, array('id'=>$idST), Entity::class);
        return $entity;    
    }
    
     
    /**
     * {@inheritdoc}   
     * @param EntityInterface $entity
     */
    public function add( EntityInterface $entity ) {
        if ( $entity->isPersisted()) {
            $sqlQuery = "UPDATE odpoved SET "                    
                      . "id_prubeh_testu_fk = :idPrubehTestuFk "                                           
                      . "stav_tabbedu = :stavTabbedu "                                           
                      . "WHERE id_odpoved = :idOdpoved";
            $this->update($sqlQuery, $entity);
        } else {
            $sqlQuery = "INSERT INTO odpoved                
                              ( id_prubeh_testu_fk, stav_tabbedu) 
                         VALUES  ( :idPrubehTestuFk, :stavTabbedu)" ;   
            $this->insert($sqlQuery, $entity);             
        }  
//    public $idOdpovedt;
//    public $idPrubehTestuFk;
//    public $inserted;
        
    }
    
    public function remove( EntityInterface $entity ) {
        $sqlQuery = "DELETE FROM odpoved "
                  . "WHERE $id_odpoved = :idOdpoved";
       
        $this->destroy($sqlQuery, $entity); //vraci null     
    }
    
      public function removeAll(){        
        $sqlQuery = "DELETE FROM odpoved "
                  . "WHERE 1=1";                 
        $this->destroyAll($sqlQuery); //vraci null    
        
    }
    
    
    
    /**
     * 
     * @param string $sqlTemplateWhere
     * @param array $poleNahrad
     * @return Entity array of
     */         
    public function find( $sqlTemplateWhere, array $poleNahrad ) {
        $sqlQuery = "SELECT  *
                     FROM odpoved". ($sqlTemplateWhere ? ' WHERE '.$sqlTemplateWhere : '');             
        $entities = $this->selectCollection($sqlQuery, $poleNahrad, Entity::class); 
        // Entity::class - jazykovy konstrukt tj.string oznacujici jmeno classy
        return $entities;
     
    }
    
}
