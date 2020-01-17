<?php
namespace Tester\Model\Db\Repository;

use Tester\Model\Db\Entity\EntityInterface;
/**
 *
 * @author vlse2610
 */
interface RepositoryInterface  {
    
    public function get( $id) ;
    
     /**
     * Uloží data entity do úložiště (databáze). 
     * V případě, že se jednalo o novou entitu (persisted=false), provede INSERT. 
     * Je-li definovano autoincrement id, nastaví do entity nově vzniklé autoincrement id.  
     * Pozn.: 'vraci'=predava se referenci ten samy objekt (v pripade INPUT s doplnenym id)  
     *     
     * @param EntityInterface $entity
     */    
    public function add( EntityInterface $entity );
    
    public function remove( EntityInterface $entity );
    public function removeAll(  );
    
    public function find( $sqlTemplateWhere, array $poleNahrad ) ;
}
