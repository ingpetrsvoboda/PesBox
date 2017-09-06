<?php

namespace Pes\Type;

/**
 * Description of ContextData
 *
 * @author pes2704
 */
class ContextData extends \ArrayObject implements ContextDataInterface {
    
    const GET_EXISTING_VALUE = 'get';
    const GET_NONEXISTING_VALUE = 'try to get unsetted value';
    const IS_EXISTiNG_VALUE = 'isset on existing value';
    const IS_NONEXISTING_VALUE = 'isset on nonexisting value';
    
    
    /**
     *
     * @var \ArrayObject or array
     */
    protected $context;
    
    private $debugMode=FALSE;
    
    private $status;
    
    public function __construct($data=NULL) {
        parent::__construct();
        if (isset($data)) {
            if (is_array($data) OR $data instanceof \ArrayObject) {
                $this->appendData($data);
            } else {
                throw new UnexpectedValueException('Argument musí být pole nebo ArrayObject.');
            }
        }
    }
    
    public function setDebugMode($debug=TRUE) {
        $this->debugMode = (boolean) $debug;
        return $this;
    }
    
    public function getDebugMode() {
        return $this->debugMode;
    }
    
    public function getStatus() {
        return $this->status;
    }
    
    public function offsetGet($index) {
        $g = parent::offsetGet($index);
        if ($this->debugMode) {
            if (isset($g)) {
                $this->status[$index][] = self::GET_EXISTING_VALUE;
            } else {
                $this->status[$index][] = self::GET_NONEXISTING_VALUE;                
            }
        }
        return $g;
    }
    
    public function offsetExists($index) {
        $e = parent::offsetExists($index);
        if ($this->debugMode) {
            if ($e) {
                $this->status[$index][] = self::IS_EXISTiNG_VALUE;
            } else {
                $this->status[$index][] = self::IS_NONEXISTING_VALUE;                
            }
        }
        return $e;
    }
    
    public function exchangeArray($data) {
        if (is_array($data)) {
            $ret = parent::exchangeArray($data);
        } elseif ($data instanceof \ArrayObject) {
            $ret = parent::exchangeArray($data->getArrayCopy());
        } else {
            throw new UnexpectedValueException('Argument musí být pole nebo ArrayObject.');
        }
        return $ret;
    }    
    
    /**
     * Metoda přidá data z pole nebo ArrayObject zadaného jako parametr.
     * @param mixed $appendedContext array nebo ArrayObject s daty.
     * @return \ContextData
     * @throws UnexpectedValueException
     */
    public function appendData($appendedData) {
        if (is_array($appendedData)) {
            parent::exchangeArray(array_merge($this->getArrayCopy(), $appendedData));
        } elseif ($appendedData instanceof \ArrayObject) {
            parent::exchangeArray(array_merge($this->getArrayCopy(), $appendedData->getArrayCopy()));
        } else {
            throw new UnexpectedValueException('Argument musí být pole nebo ArrayObject.');
        }
        return $this;
    }    
    
    public function assign($name, $value) {
        $this->offsetSet($name, $value);
        return $this;
    }
}
