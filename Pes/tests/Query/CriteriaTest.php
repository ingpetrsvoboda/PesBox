<?php
use Pes\Query\Criteria;

/**
 * Description of CriteriaTest
 *
 * @author pes2704
 */
class CriteriaTest extends PHPUnit_Framework_TestCase {
    
    private $arrayParam;
    private $objectParam;
    /**
     * setUp - nastavuje arrayParam pro testování dat ve formě pole a současně také objectParam
     * pro testování dat ve formě objektu. Všechny asserty jsou vždy dvakrát - jednou prole, podruhé pro objekt
     */
    public function setUp() {
        $this->arrayParam['a'] = 555;
        $this->arrayParam['b'] = 666;
        $this->arrayParam['name'] = 'Alibaba';
        $this->objectParam = (object) $this->arrayParam;
    }
    
    /**
     * data provider pro testConditionsMatch 
     * Generuje jednotlivá kritérie - paremtry pro volání metody testConditionsMatch()
     * @return type
     */    
    public function testConditionsMatchValuesProvider() {
//  Podmínky jsou: "=":"!=";"<>":"<":"<=":">":">=":"LIKE":"IN":"NOT IN":        
        
        $data[] = array(array(array('a', '=', 555)), '', TRUE); 
        $data[] = array(array(array('a', '=', '555')), '', TRUE);        
        $data[] = array(array(array('b', '=', '666')), '', TRUE); 
        $data[] = array(array(array('a', 'IN', array(111,222,333,444,555))), '', TRUE);
        $data[] = array(array(array('a', 'NOT IN', array(111,222,333,444,555))), '', FALSE);
        $data[] = array(array(array('b', 'IN', array(111,222,333,444,555))), '', FALSE);
        $data[] = array(array(array('b', 'NOT IN', array(111,222,333,444,555))), '', TRUE);
        
        $data[] = array(array(array('name', '=', 'Alibaba')), '', TRUE); 
        $data[] = array(array(array('qqqq', '=', 'Alibaba')), '', FALSE); // qqqq v datech není -> vždy FALSE
        $data[] = array(array(array('name', 'LIKE', '%liba%')), '', TRUE); 
        
        $data[] = array(array(array('a', '=', '555'), array('b', '=', '666')), 'AND', TRUE); 
        $data[] = array(array(array('a', '!=', '556'), array('b', '<>', 'q')), 'AND', TRUE); 
        $data[] = array(array(array('a', '=', '55')), '', FALSE); 
        $data[] = array(array(array('b', '=', '66')), '', FALSE); 
        $data[] = array(array(array('a', '=', '555'), array('b', '=', '66')), 'AND', FALSE); 
        $data[] = array(array(array('a', '!=', '555'), array('b', '<>', 'q')), 'AND', FALSE); 

        $data[] = array(array(array('a', '=', '555'), array('b', '<>', 666), array('name', 'LIKE', 'Ali%')), 'AND', FALSE); 
        $data[] = array(array(array('a', '=', '555'), array('b', '<>', 666), array('name', 'LIKE', 'Ali%')), 'OR', TRUE); 
        #
        
        return $data;
    }
    /**
     * Tettuje různé podmínky (jen některé vybrané). Daty tento test zásobuje data provider.
     * @param type $arrayConditions
     * @param type $logicalOperator
     * @param type $result
     *  
     * @dataProvider testConditionsMatchValuesProvider
     */
    public function testConditionsMatch($arrayConditions, $logicalOperator, $result) {
        $criteria = new Criteria($logicalOperator);
        foreach ($arrayConditions as $cond) {
            $criteria = $criteria->addConditionByOperator($cond[0], $cond[1], $cond[2]); 
        }
        if ($result) {
            $this->assertTrue($criteria->match($this->arrayParam)); 
            $this->assertTrue($criteria->match($this->objectParam)); 
        } else {
            $this->assertFalse($criteria->match($this->arrayParam));             
            $this->assertFalse($criteria->match($this->objectParam));             
        }
               
    }   
    
    
    public function testCriteriaAndConditionMatch() {
        //první subkritérium - pravdivé
        $subCriteria1 = new Criteria(); //AND
        $subCriteria1->addConditionByOperator("a", '=', 555); 
        $subCriteria1->addConditionByOperator("b", '!=', 555); 
        // druhé subkritérium - pravdivé
        $subCriteria2 = new Criteria(); //AND
        $subCriteria2->addConditionByOperator('name', '=', 'Alibaba'); 
        $subCriteria2->addConditionByOperator('name', '!=', 'Loupežník'); 
        // složené kritérium - $subCriteria1 OR $subCriteria2 - pravdivé
        $criteria = new Criteria('OR');
        $criteria->addSubCriteria($subCriteria1)->addSubCriteria($subCriteria2);
        //assert pravda
            $this->assertTrue($criteria->match($this->arrayParam)); 
            $this->assertTrue($criteria->match($this->objectParam)); 
        // k prvnímu subkritériu přidána další podmínka - výsledek nepravda
        $subCriteria1->addConditionByOperator("b", '=', 555); 
        //ještě assert pravda $subCriteria1 OR $subCriteria2 -> FALSE OR TRUE = TRUE
            $this->assertTrue($criteria->match($this->arrayParam)); 
            $this->assertTrue($criteria->match($this->objectParam)); 
        // k druhému subkritériu přidána další podmínka - výsledek nepravda
        $subCriteria2->addConditionByOperator('name', '=', 'Loupežník');    
        // už assert nepravda - $subCriteria1 OR $subCriteria2 -> FALSE OR FALSE = FALSE
            $this->assertFalse($criteria->match($this->arrayParam));             
            $this->assertFalse($criteria->match($this->objectParam));  
        // k složeném kritériu přidána podmínka - pravdivá
        $criteria->addConditionByOperator('name', 'LIKE', '%liba%');
        // assert pravda $subCriteria1 OR $subCriteria2 OR condition -> FALSE OR FALSE OR TRUE = TRUE
            $this->assertTrue($criteria->match($this->arrayParam)); 
            $this->assertTrue($criteria->match($this->objectParam));         
    } 
}