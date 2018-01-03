<?php

namespace Framework\Di;

use Psr\Container\ContainerInterface;
use Framework\Di\ExceptionHelper;
use Framework\Di\Exception\NotFoundException;

/**
 * Description of Container
 *
 * @author pes2704
 */
class Container implements ContainerInterface {
    
    /**
     * A container that will be used instead of the main container
     * to fetch dependencies.
     *
     * @var ContainerInterface
     */
    protected $delegateContainer;

    /**
     * Asiciativní pole service indexovaných podle jména service
     *
     * @var array
     */
    protected $services = [];
    
    /**
     * Obsahuje již vytvořené instance objektů vytvořených voláním service (get($service)).
     *
     * @var array
     */
    protected $instances = [];
    
    /**
     * Signalizuje uzamčený kontejner.
     * @var boolean 
     */
    private $locked;
    /**
     * Constructor.
     *
     * @param InjectionFactory $injectionFactory A factory to create objects and
     * values for injection.
     *
     * @param ContainerInterface $delegateContainer An optional container
     * that will be used to fetch dependencies (i.e. lazy gets)
     *
     */
    public function __construct(ContainerInterface $delegateContainer = null) {
        $this->delegateContainer = $delegateContainer;
    }
    
    /**
     * Does a particular service definition exist?
     *
     * @param string $service The service key to look up.
     * @return bool
     */
    public function has($service) {
        return (isset($this->services[$service])) OR isset($this->delegateContainer) AND $this->delegateContainer->has($service);
    }    
    
    /**
     * Nastaví definici service s daným jménem. Service je Closure.
     * @param string $serviceName
     * @param \Closure $serviceClosure
     * @return $this
     */
    public function set($serviceName, \Closure $serviceClosure)
    {
        $this->services[$serviceName] = $serviceClosure;
        return $this;
    }
    
    /**
     *
     * Vrací návratový objekt service zadaného jména. Vrací vžfy tentýř objekt, který byl vrácen při prvním volání této metody get() se stejným jménem service.
     *
     * @param string $service Jméno service.
     *
     * @return object
     *
     * @throws Exception\ServiceNotFound when the requested service
     * does not exist.
     *
     */
    /**
     * 
     * @param type $service
     * @return type
     */
    public function get($service)
    {
        if (!isset($this->instances[$service])) {
            $this->instances[$service] = $this->getServiceInstance($service);
        }
        return $this->instances[$service];
    }    

    /**
     *
     * Instantiates a service object by key, lazy-loading it as needed.
     *
     * @param string $service The service to get.
     *
     * @return object
     *
     * @throws Exception\ServiceNotFound when the requested service
     * does not exist.
     *
     */
    /**
     * 
     * @param type $service
     * @return type
     * @throws Exception\NotFoundException
     */
    protected function getServiceInstance($service) {
        // does the definition exist?
        if (! $this->has($service)) {
            throw new NotFoundException(ExceptionHelper::ServiceNotFound($service));
        }
        // is it defined in this container?
        if (isset($this->services[$service])) {
        // instantiate it from its definition
            $closure = $this->services[$service];
            $instance = $closure();
        } else {
        // no, get the instance from the delegate container
            $instance = $this->delegateContainer->get($service);
        }

        // done
        return $instance;
    }

    /**
     * Locks the Container so that is it read-only.
     *
     * @return null
     */
    public function lock() {
        $this->locked = true;
    }
    
    /**
     * Is the Container locked?
     *
     * @return bool
     */
    public function isLocked() {
        return $this->locked;
    }    
}