<?php
namespace Pes\Database\Handler\AttributesProvider;

use Pes\Database\Handler\ConnectionInfo;
use Psr\Log\LoggerInterface;

/**
 * AttributesProviderAbstract přijímá nepoviný parametr - pole atributů. Pokud je zadán, pak hodnoty atributů v něm zadané mají přednost (přepíší) 
 * hodnoty nastavované příslušným potomkem. 
 *
 * @author pes2704
 */
abstract class AttributesProviderAbstract implements AttributesProviderInterface {
    
    protected $logger;
    protected $connectionInfo;
    
    public function __construct(LoggerInterface $logger, ConnectionInfo $connectionInfo=NULL) {
        $this->logger = $logger;
        $this->connectionInfo = $connectionInfo;
    }
}
