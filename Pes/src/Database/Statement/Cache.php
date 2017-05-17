<?php
namespace Pes\Database\Statement;

/**
 * Description of Cache
 * Specializovaná cache pro ukládání připravených (prepared) objektů typu StatementInterface (potomků PDOStatement).
 *
 * @author pes2704
 */
class Cache implements CacheInterface {
        
    protected $statements = array();
    
    /**
     * Vrací uložený statement se zadanou signaturou.
     * @param scalar $statementSignature
     * @return Framework_Database_Statement_Sql
     */
    public function getStatement($statementSignature) {
        if ($this->hasStatement($statementSignature)) {
            return $this->statements[$statementSignature];
        }
    }

    /**
     * 
     * @param scalar $statementSignature
     * @param StatementInterface $dbStatement
     * @throws UnexpectedValueException
     */
    public function setStatement($statementSignature, StatementInterface $dbStatement) {
        if(!is_scalar($statementSignature)) {
            throw new UnexpectedValueException('Signatura musí být skalárního typu.');
        }
        $this->statements[$statementSignature] =  $dbStatement;
    }
    
    /**
     * Informuje zde existuje uložený statement se zadanou signaturou.
     * @param scalar $statementSignature
     * @return boolean
     */
    public function hasStatement($statementSignature) {
        return isset($this->statements[$statementSignature]);
    }
    
    /**
     * Vrací pole signatur uložených statements. Jako signatury se obvykle používají řetězce SQL query touto metodou lze získat informativní seznam 
     * query, pro které byly vytvořeny statementy.
     * @return type
     */
    public function getCachedStatentsSignature() {
        return array_keys($this->statements);
    }
}
