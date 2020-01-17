<?php
namespace Tester\Model\Db\Repository;

use Tester\Model\Db\Entity\EntityInterface;

use Pes\Database\Handler\HandlerInterface;
//use Pes\Database\Handler\Handler;

use Pes\Database\Metadata\MetadataProviderInterface;
use Pes\Database\Metadata\TableMetadataInterface;
use Pes\Database\Metadata\ColumnMetadataInterface;
use Tester\Model\Db\Hydrator\HydratorInterface;

/**
 * Description of RepositoryAnstract
 *
 * @author vlse2610
 */
abstract class RepositoryAbstract implements RepositoryInterface {

    /**
     * @var HandlerInterface
     */
    private $dbh;
    
    /**
     * @var TableMetadataInterface
     */
    protected $tableMetadata;   //$tableMetadata -> columns[jm_sl]-objekty

    /**
     * @var HydratorInterface 
     */
    private $hydrator;
    
    public function __construct( HandlerInterface $dbh, 
                                $tableName, 
                                MetadataProviderInterface $metadataProvider, 
                                HydratorInterface $hydrator) {
        $this->dbh = $dbh;
        $this->tableMetadata = $metadataProvider->getTableMetadata($tableName); //$tableMetadata - columns[jm_sl]-objekty
        $this->hydrator = $hydrator;
    }

    /**
     * 
     * @param string $sqlQuery SQL string
     * @param array $params Parametry pro bindValue - náhrady placeholderů
     * @param string $entityClassName Jméno třídy entity, která bude vytvořena.
     * @return EntityInterface
     * @throws \DbRepositoryException
     */
    protected function selectEntity($sqlQuery, $params, $entityClassName) {
        $statement = $this->createSqlSelect($sqlQuery, $params);
        if ($statement->execute()) {
            $poc = $statement->rowCount();
            if ($poc===1 ) {
                $entity = $this->createEntity($statement->fetch(\PDO::FETCH_ASSOC), $entityClassName);
            } elseif($statement->rowCount()>0) {
                //throw new \DbRepositoryException('(select Entity) - Vybráno víc řádek podle id.');
                throw new Tester\Model\Db\Repository\DbRepositoryException('(select Entity) - Vybráno víc řádek podle id.');
            }
        } else {
            throw new \DbRepositoryException('(select Entity) - Selhal SQL příkaz select.');
        }
        return $entity ?? NULL;
    }

    /**
     * 
     * @param string $sqlQuery SQL string
     * @param array $params Parametry pro bindValue - náhrady placeholderů
     * @param string $entityClassName Jméno třídy entity, která bude vytvořena.
     * @return EntityInterface array of
     * @throws \DbRepositoryException
     */
    protected function selectCollection($sqlQuery, $params, $entityClassName) {
        $statement = $this->createSqlSelect($sqlQuery, $params);
        if ($statement->execute()) {
            $res = $statement->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($res as $resultRow) {
                $entities[] = $this->createEntity($resultRow, $entityClassName);
            }
        } else {
            throw new \DbRepositoryException('(selectCollection) -  Selhal SQL příkaz select.');
        }
        return $entities ?? NULL;

    }



    private function createSqlSelect($sqlQuery, $params) {           
        
        $statement = $this->dbh->prepare($sqlQuery);
        foreach ($params as $key => $value) {
            $placeholder = ':'.$key;
            if (strpos($statement->queryString, $placeholder) !== FALSE) {
                $statement->bindValue($placeholder, $value);
            }
        }  
        return $statement;
    }
    
    /**
     * Vyrobí novou entitu a naplní ji daty z řádku dat.
     * 
     * @param array $row
     * @param string $entityClassName
     * @return EntityInterface
     */
    private function createEntity($row, $entityClassName) {
        $entity = new $entityClassName();
        /* @var $entity EntityInterface */
        $entity->setPersisted(TRUE);
        foreach ($row as $name=>$value) {
            /* @var $columnMetadata ColumnMetadataInterface  */        
            $entity = $this->hydrator->hydrate($value, $entity, $this->tableMetadata->getColumnMetadata($name), $this->tableMetadata);
        }
        return $entity;
    }

    /**
     * 
     * @param string $sqlQuery
     * @param EntityInterface $entity
     * @param string $uidPropertyName
     * @throws \DbRepositoryException
     */
    protected function insertWithUid($sqlQuery, EntityInterface $entity, $uidPropertyName) {
//        $oldHandler = set_exception_handler(NULL);
        try {
            $this->dbh->beginTransaction();        
            $entity->$uidPropertyName = $this->getNewUidWithinTransaction($uidPropertyName); 
            $statement = $this->dbh->prepare($sqlQuery);
            $this->bindProperties($statement, $entity);
            $statement->execute();
            $this->setEntityId($entity);    
            $this->dbh->commit();
            $entity->setPersisted(TRUE);            
        } catch(Exception $e) {
            $this->dbh->rollBack();
            $entity->$uidPropertyName = NULL;
            throw new \DbRepositoryException('(insertWithUid) - Selhala transakce insert.',0,$e);          
        } 
//        restore_exception_handler();            
    }
    
    /**
     * 
     * @param string $sqlQuery
     * @param EntityInterface $entity
     * @throws \DbRepositoryException
     */
    protected function insert($sqlQuery, EntityInterface $entity) {    
        try {
            $this->dbh->beginTransaction(); 
            
            $statement = $this->dbh->prepare($sqlQuery);
            $this->bindProperties($statement, $entity);
            $statement->execute();
            $this->setEntityId($entity);
            $this->dbh->commit();
            $entity->setPersisted(TRUE);
        } catch(Exception $e) {
            $this->dbh->rollBack();
            throw new \DbRepositoryException('(insert) - Selhal SQL příkaz insert.');
        }

    }
    
    /**
     * 
     * @param EntityInterface $entity
     */
    private function setEntityId(EntityInterface $entity) {
        foreach ($this->tableMetadata->getPrimaryKeyAttribute() as $name) {
            if($this->tableMetadata->getColumnMetadata($name)->isGenerated()) {
                $propertyName = $this->nameHydrate($name);
                $i = $this->dbh->lastInsertId();
                $entity->$propertyName = $i;
            }
        }
    }

    /**
     * 
     * @param string $sqlQuery
     * @param EntityInterface $entity
     * @return boolean
     * @throws DbRepositoryException
     * @throws \Exception
     */
    protected function update($sqlQuery, EntityInterface $entity) {
//        set_exception_handler(NULL);
        try {
            $this->dbh->beginTransaction(); 
           
            $statement = $this->dbh->prepare( $sqlQuery);
            $this->bindProperties($statement, $entity);
            $statement->execute();
            $countR = $statement->rowCount();
            if ($countR > 1) {
                $this->dbh->rollBack();
                throw new \Exception('(update) - Pokus o update více bež 1 řádku v '.get_called_class().'. Transakce zrušena.');
            } else {
                $this->dbh->commit();
                $entity->setPersisted(TRUE);                
            }
        } catch(\Exception $e) {
            $this->dbh->rollBack();
            throw new DbRepositoryException('(update) - Selhala transakce update.',0,$e);
        }
//        restore_exception_handler();
        if ($countR ===0) {
            throw new DbRepositoryException('(update) - Nepodařil se update. Update 0 řádek.');
        }
    }

    
    /**
     * Vykona DELETE v databazi a nastavi objekt jako neperzistovany tim, ze mu sebere id (tj. nastavi vlastnost id ns NULL). 
     * @param string $sqlQuery
     * @param EntityInterface $entity
     * @throws \DbRepositoryException
     * @throws \Exception
     */
    protected function destroy($sqlQuery,  EntityInterface $entity) {
        try {
            $this->dbh->beginTransaction();
            $statement = $this->dbh->prepare($sqlQuery);
            $this->bindProperties($statement, $entity);
            $statement->execute();   //!DULEZITE SDELENI! -timto prikazem vymazu ulozene vlastnosti  objektu (ty persistovane) z databaze.
            if ($statement->rowCount()>1) {
                throw new \Exception('(destroy) - Pokus o delete více bež 1 řádku v '.get_called_class().'. Transakce zrušena.');
            } else {
                $this->dbh->commit();
                $entity->setPersisted(FALSE);                
            }
              
            if ($statement->rowCount()==0) {
                //user_error('Mazal jsi co nebylo zapsáno, ty trubko!', E_USER_NOTICE);
                user_error('(destroy) - Pokus o mazání neexistují řádky!', E_USER_NOTICE);
            }
            foreach ($this->tableMetadata->getPrimaryKeyAttribute() as $name) {
                $propertyName = $this->nameHydrate($name);
                $entity->$propertyName = NULL;   //!DULEZITE SDELENI! -timto prikazem "rusim 'náš' priznak", ze je objekt persistovan v databazi.
            }
        } catch(\Exception $e) {
            throw new \DbRepositoryException('(destroy) - Selhal SQL přikaz - nepodařil se v destroy.', 0, $e);
        }
    }

    protected function destroyWithUid($sqlQuery,  EntityInterface $entity, $uidPropertyName) {
        $this->destroy($sqlQuery, $entity);
        $entity->$uidPropertyName = NULL;
    }
    
    
    
    protected function destroyAll($sqlQuery) {
        
            $statement = $this->dbh->prepare($sqlQuery);
            //$this->bindProperties($statement, $entity);
            $statement->execute();  
    }
        


    
    
    //----------------------------------------------------------------------------------------------

    protected function bindProperties(\PDOStatement $statement, EntityInterface &$entity) {
        
        foreach ($entity as $propertyName=>$value) {            
            
            $columnName = $this->nameExtract($propertyName);            
            $columnMetadata = $this->tableMetadata->getColumnMetadata($columnName);
            
            
            if ($columnMetadata) {
                $placeholder = ':'.$propertyName;
                // v SQL je odpovídající placeholder => pokud je hodnota NULL a je placeholder chci ukládat i hodnotu NULL
                if (strpos($statement->queryString, $placeholder) !== FALSE) {  
                    $statement->bindValue($placeholder, $this->hydrator->extract($propertyName, $entity, $columnMetadata,  $this->tableMetadata ));
                }
            } else {
                throw new \UnexpectedValueException("(bindProperties) - Neznámý název sloupce $columnName při pokusu o zápis v ". get_called_class());
            }
        }
        return $statement;
    }

        /**
     * Generuje uid unikátní v rámci tabulky. 
     * 
     * Generuje uid pomocí PHP funkce uniqid(), ale ověří, že vygenerované uid skutečně není v tabulce dosud použito, pokud je, generuje nové uid.  
     * Aby byla zaručena unikátnost uid v rámci jedné tabulky, je nutné, aby čtení tabulky při zjišťování existence uid a následný zápis nového
     * zázamu proběhly se zamčenou tabulkou. Tato metoda používá příkaz "SELECT uid FROM table WHERE uid = :uid LOCK IN SHARE MODE", který zamkne přečtené záznamy až
     * do okamžiku ukončení transakce. Proto lze tuto metodu použít jen uprostřed již spuštěné transakce. Volání této metody mimo spuštěnou transakci vyvolá výjimky.  
     */
    private function getNewUidWithinTransaction($uidPropertyName) {        
        if ($this->dbh->inTransaction()) {
            $tableName = $this->tableMetadata->getTableName();
            $columnName = $this->nameExtract($uidPropertyName);     
            $placeholder = ':'.$uidPropertyName;
            $columnMetadata = $this->tableMetadata->getColumnMetadata($columnName);
            if ($columnMetadata) {            
                do {
                    $uid = uniqid();
                    $stmt = $this->dbh->prepare(
                            "SELECT $columnName 
                            FROM $tableName
                            WHERE $columnName = $placeholder LOCK IN SHARE MODE");   //nelze použít LOCK TABLES - to commitne aktuální transakci!
                    $stmt->bindParam($placeholder, $uid);
                    $stmt->execute();
                } while ($stmt->rowCount());  
                return $uid;
            } else {
                throw new \UnexpectedValueException("(getNewUidWithinTransaction) - Zadané jméno vlastnosti $uidPropertyName vede na neexistující sloupec $uidColumnName.");
            }
        } else {
            throw new \LogicException('(getNewUidWithinTransaction) - Tuto metodu lze volat pouze uprostřed spuštěné databázové transakce.');
        }
    }
    


  //yase pridane VS
    
    protected function extract($propertyName, EntityInterface $entity, ColumnMetadataInterface $columnMetadata) {
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

    protected function hydrate($value, EntityInterface $entity, ColumnMetadataInterface $columnMetadata) {
        $columnType = $columnMetadata->getType();
        $propertyName = $this->nameHydrate($columnMetadata->getName());
        switch ($columnType) {
            case 'datetime':
                $datetime = \DateTime::createFromFormat("Y-m-d H:i:s", $value);
                $entity->$propertyName = ($datetime !== FALSE) ? $datetime : NULL;
                break;

            default:
                $entity->$propertyName = $value;
                break;
        }
    }
    
    protected function nameHydrate($underscoredName){
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $underscoredName))));
    }

    protected function nameExtract($camelCaseName) {
        return strtolower(preg_replace( '/([a-z0-9])([A-Z])/', "$1_$2", $camelCaseName ));
    }
    
    
    
    
}
