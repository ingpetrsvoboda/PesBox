<?php
namespace Pes\Validator;
/**
 * Description of IsTypeValidator
 *
 * @author pes2704
 */
class IsTypeValidator implements ValidatorInterface {
    private $type;
   
    /**
     * 
     * @param string $type Type name - name of interface or class (full name with namespace).
     * @throws \InvalidArgumentException
     */
    public function __construct($type) {
        if (is_string($type)) {
            if (interface_exists($type)) {
                $this->type = $type;
            } elseif (class_exists($type)) {
                $this->type = $type;
            } else {
                throw new \InvalidArgumentException('No such interface or class is defined: '.$type);
            }
        } else {
            throw new \InvalidArgumentException('Parameter must be a string.');
        }
        ;
    }
    public function isValid($param) {
        return $param instanceof $this->type ? TRUE : FALSE;
    }
}
