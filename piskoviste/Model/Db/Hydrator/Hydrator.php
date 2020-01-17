<?php

namespace Tester\Model\Db\Hydrator;

use Tester\Model\Db\Entity\EntityInterface;
use Pes\Database\Metadata\ColumnMetadataInterface;
use Pes\Database\Metadata\TableMetadataInterface;

/**
 * Description of Hydrator
 *
 * @author vlse2610
 */
class Hydrator implements HydratorInterface {
    
    private $nameHydrator;
    
    public function __construct(NameHydratorInterface $nameHydrator) {
        $this->nameHydrator = $nameHydrator;
    }
    
    
    public function extract( $propertyName, EntityInterface $entity, 
                             ColumnMetadataInterface $columnMetadata /*asi nebude*/, TableMetadataInterface $tableMetaData) {
    //public function extract( $propertyName, EntityInterface $entity, ColumnMetadataInterface $columnMetadata) {
        $value = $entity->$propertyName;
        $type = $columnMetadata->getType();
        if($value instanceof \DateTime) {
            if ($type == 'datetime' OR $type=='timestamp') {
                $ret = $value->format("Y-m-d H:i:s");
            } elseif ($type=='date') {
                $ret = $value->format("Y-m-d");
            } else {
                $ret = $value->format("d.m.Y H:i:s");
            }
        } else {
            $ret = $value;
        }
        return $ret;
    }

    
    public function hydrate( $value, EntityInterface $entity, 
                             ColumnMetadataInterface $columnMetadata /*nebude*/, TableMetadataInterface $tableMetaData) {
    //public function hydrate( $value, EntityInterface $entity, ColumnMetadataInterface $columnMetadata) {
        $columnType = $columnMetadata->getType();
        $propertyName = $this->nameHydrator->hydrate($columnMetadata->getName());
        switch ($columnType) {
            case 'datetime':
                $datetime = \DateTime::createFromFormat("Y-m-d H:i:s", $value);
                $entity->$propertyName = ($datetime !== FALSE) ? $datetime : NULL;
                break;

            default:
                $entity->$propertyName = $value;
                break;
        }
        return $entity;
    }
}
