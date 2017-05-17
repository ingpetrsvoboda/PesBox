<?php 
namespace Pes\Database\Statement;

interface CacheInterface { 
    public function getStatement($statementSignature);
    public function setStatement($statementSignature, StatementInterface $dbSDtatement);
    public function hasStatement($statementSignature);
}