<?php
namespace Tester\Model\Db\Hydrator;

use Tester\Model\Db\Entity\EntityInterface;
use Pes\Database\Metadata\ColumnMetadataInterface;
use Pes\Database\Metadata\TableMetadataInterface;
/**
 *
 * @author vlse2610
 */;
interface HydratorInterface {
    
    public function extract( $propertyName, EntityInterface $entity, 
                             ColumnMetadataInterface $columnMetadata /*asi nebude*/, TableMetadataInterface $tableMetaData) ;
    public function hydrate( $value, EntityInterface $entity, 
                             ColumnMetadataInterface $columnMetadata /*nebude*/, TableMetadataInterface $tableMetaData);
}
