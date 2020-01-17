<?php

namespace Tester\Model\Db\Repository;


use Tester\Model\Db\Entity\EntityInterface;
use Tester\Model\Db\Entity\OdpovedNaOtazku as Entity;


/**
 * Description of OdpoverdOtazka
 *
 * @author vlse2610
 */
class OdpovedNaOtazku extends RepositoryAbstract implements OdpovedInterface {
//class Odpoved extends RepositoryAbstract implements OdpovedInterface    
    
    public function get( $id) {
        $sqlQuery = "SELECT  * 
                     FROM odpoved_na_otazku                 
                     WHERE  id_odpoved_na_otazku = :id";                       
        $entity = $this->selectEntity($sqlQuery, array('id'=>$id), Entity::class);
        return $entity;    
    }

 // v odpovedNaOtazku je jich 1 a vice, hledam kolekci --- takze nam staci find()
//     public function getBySpustenyTestId( $idST) {            
//        $sqlQuery = "SELECT  * 
//                     FROM odpoved_na_otazku                 
//                     WHERE  id_spusteny_test_fk = :id";                       
//        $entity = $this->selectCollection($sqlQuery, array('id'=>$idST), Entity::class);
//        return $entity;    
//    }
    
    
    /**
     * {@inheritdoc}   
     * @param EntityInterface $entity
     */
    public function add( EntityInterface $entity ) {
        if ( $entity->isPersisted()) {
            $sqlQuery = "UPDATE odpoved_na_otazku SET "
                      . "id_prubeh_testu_fk = :idPrubehTestuFk, "                                         
                      . "identifikator_odpovedi = :identifikatorOdpovedi, " 
                      . "hodnota = :hodnota"                          
                      . "WHERE id_sada_otazek = :idSadaOtazek";
            $this->update($sqlQuery, $entity);
        } else {
            $sqlQuery = "INSERT INTO odpoved_na_otazku                                                
                              (id_prubeh_testu_fk, identifikator_odpovedi, hodnota ) 
                         VALUES  ( :idPrubehTestuFk, :identifikatorOdpovedi, :hodnota )" ;   
            $this->insert($sqlQuery, $entity);             
        }  
    }

    
    
    public function remove( EntityInterface $entity ) {
        $sqlQuery = "DELETE FROM odpoved_na_otazku "
                  . "WHERE id_odpoved_na_otazku = :idOdpovedNaOtazku";
       
        $this->destroy($sqlQuery, $entity); //vraci null        
    }
    
    
    public function removeAll(){        
        $sqlQuery = "DELETE FROM odpoved_na_otazku "
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
                     FROM odpoved_na_otazku". ($sqlTemplateWhere ? ' WHERE '.$sqlTemplateWhere : '');             
        $entities = $this->selectCollection($sqlQuery, $poleNahrad, Entity::class); 
        // Entity::class - jazykovy konstrukt tj.string oznacujici jmeno classy
        return $entities;
        
    }
}
