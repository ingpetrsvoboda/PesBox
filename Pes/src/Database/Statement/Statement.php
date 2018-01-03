<?php
/**
 * Základní statement objekt pro SQL databáze. Využívá hotovou abstrakci PHP PDOStatement a jde o adapter a současně wrapper 
 * pro PDOStatement. 
 *
 * @author Petr Svoboda
 */
namespace Pes\Database\Statement;

use Psr\Log\LoggerInterface;

class Statement extends \PDOStatement implements StatementInterface {
    
    /**
     * Čítač instancí pro logování
     * @var int 
     */
    private static $statementCounter=0;
    
    /**
     * @var LoggerInterface 
     */
    protected $logger;
    
    protected function __construct(LoggerInterface $logger) {  
        $this->logger = $logger;
        self::$statementCounter++;
        // konstruktor musí být deklarován i když je prázdný
        // bez toho nefunguje PDO::setAttribute(PDO::ATTR_STATEMENT_CLASS, ...
    }
    
    private function getInstanceInfo() {
        return 'Statement '.self::$statementCounter;
    }      
    
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null) {
        // This thin wrapper is necessary to shield against the weird signature
        // of PDOStatement::setFetchMode(): even if the second and third
        // parameters are optional, PHP will not let us remove it from this
        // declaration.
        if ($arg2 === null && $arg3 === null) {
            $this->logger->debug($this->getInstanceInfo().' setFetchMode({fetchMode})', array('fetchMode'=>$fetchMode));
            return parent::setFetchMode($fetchMode);
        }
        if ($arg3 === null) {
            $this->logger->debug($this->getInstanceInfo().' setFetchMode({fetchMode}, {arg2})', array('fetchMode'=>$fetchMode, 'arg2'=>$arg2));
            return parent::setFetchMode($fetchMode, $arg2);
        }
        $this->logger->debug($this->getInstanceInfo().' setFetchMode({fetchMode}, {arg2}, {arg3})', array('fetchMode'=>$fetchMode, 'arg2'=>$arg2, 'arg3'=>$arg3));
        return parent::setFetchMode($fetchMode, $arg2, $arg3);
    }
    
    public function fetch($fetch_style = null, $cursor_orientation = \PDO::FETCH_ORI_NEXT, $cursor_offset = 0) {
        $this->logger->debug($this->getInstanceInfo().' fetch({fetch_style}, {cursor_orientation}, {cursor_offset})', array('fetch_style'=>$fetch_style, 'cursor_orientation'=>$cursor_orientation, 'cursor_offset'=>$cursor_offset));
        return parent::fetch($fetch_style, $cursor_orientation, $cursor_offset);
    }
    
    public function fetchAll($fetch_style = NULL, $fetch_argument = NULL, $ctor_args = NULL) {
        // This thin wrapper is necessary to shield against the weird signature
        // of PDOStatement::setFetchMode(): even if the second and third
        // parameters are optional, PHP will not let us remove it from this
        // declaration.
        if ($fetch_argument === NULL && $ctor_args === NULL) {
            $this->logger->debug($this->getInstanceInfo().' fetchAll({fetch_style})', array('fetch_style'=>$fetch_style));
            return parent::fetchAll($fetch_style);
        }
        if ($ctor_args === NULL) {
            $this->logger->debug($this->getInstanceInfo().' fetchAll({fetch_style}, {fetch_argument})', array('fetch_style'=>$fetch_style, 'fetch_argument'=>$fetch_argument));
            return parent::fetchAll($fetch_style, $fetch_argument);
        }
        $this->logger->debug($this->getInstanceInfo().' fetchAll({fetch_style}, {fetch_argument}, {ctor_args})', array('fetch_style'=>$fetch_style, 'fetch_argument'=>$fetch_argument, 'ctor_args'=>$ctor_args));
        return parent::fetchAll($fetch_style, $fetch_argument, $ctor_args);        
    }
    
    public function execute($input_parameters = NULL) {
        $this->logger->debug($this->getInstanceInfo().' execute({input_parameters})', array('input_parameters'=>$input_parameters));
        return parent::execute($input_parameters);
    }    
}
