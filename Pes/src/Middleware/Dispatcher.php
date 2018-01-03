<?php

/**
 * Description of Dispatcher
 *
 * @author Rasmus Schultz mindplay-dk https://github.com/mindplay-dk/middleman, úprava pes2704
 * Úprava na poslední verzi Interop\Http\Server - MiddlewareInterface a RequestHandlerInterface + vrací Pes\Http\ResponseInterface
 */

namespace Pes\Middleware;

use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * PSR-7 / PSR-15 middleware dispatcher
 */
class Dispatcher implements MiddlewareInterface
{
    /**
     * @var callable middleware resolver
     */
    private $resolver;
    
    /**
     * @var mixed[] unresolved middleware stack
     */
    private $stack;
    
    /**
     * Přijímá zásobník middleware a případně resolver. Položky zásobníku middleware jsou jednotlivá middleware nebo callable nebo, v případě zadaného resolveru, 
     * libovolné hodnoty. Resolver je anonymní funkce, která je volána při vyhodnocování zásobníku, položka zásobníku je použita jako argument 
     * resolveru a resolver vrací middleware nebo callable, které je následně spuštěno.
     * 
     * @param (callable|MiddlewareInterface|mixed)[] $stack Zásobník middleware (s alespoň jedním prvvkem) ve formě pole, zásobník je vyhodnocován od nejnižšího indexu
     * @param callable|null $resolver optional middleware resolver:
     *                                function (string $name): MiddlewareInterface
     *      
     * @throws InvalidArgumentException if an empty middleware stack was given
     */
    public function __construct($stack, callable $resolver = null)
    {
        if (count($stack) === 0) {
            throw new \InvalidArgumentException("Prázdný zásobník middleware.");
        }
        $this->stack = $stack;
        $this->resolver = $resolver;
    }
    /**
     * Dispatches the middleware stack and returns the resulting `ResponseInterface`.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws LogicException on unexpected result from any middleware on the stack
     */
    public function dispatch(ServerRequestInterface $request)
    {
        $resolved = $this->resolve(0);
        return $resolved($request);
    }
    
    /**
     * {@inheritdoc}
     * 
     * impementace přijímá PSR request a vrací PSR response, není implementován Pes\Http\RequestInterface a Pes\Http\ResponseInterface 
     * (to by vyžadovalo Pes interface - potomky Interop interface)
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->stack[] = function (ServerRequestInterface $request) use ($handler) {
            return $handler->process($request);
        };
        $response = $this->dispatch($request);
        array_pop($this->stack);
        return $response;
    }
    
    /**
     * Projde celý zásobník, pokud je zadán resolver, REKURZIVNÉ projde celý zásobník - prvek zásobníku nejprve resolvuje, 
     * pak volá metodu prvku ->process(), které jako druhý parament předá další položku zásobníku.
     * 
     * @param int $index middleware stack index
     *
     * @return RequestHandlerInterface
     */
    private function resolve($index) {
        if (isset($this->stack[$index])) {
            return new RequestHandler(function (ServerRequestInterface $request) use ($index) {
                //zavolá na položku resolver (výsledek musí být middleware nebo callable) nebo použije položku
                $middleware = $this->resolver ? call_user_func($this->resolver, $this->stack[$index]) : $this->stack[$index]; 
                switch (true) {
                    case $middleware instanceof MiddlewareInterface:
                        $result = $middleware->process($request, $this->resolve($index + 1));
                        break;
                    case is_callable($middleware):
                        $result = $middleware($request, $this->resolve($index + 1));
                        break;
                    default:
                        throw new \UnexpectedValueException("Nepodporovaný typ middleware v zásobníku s indexem {index}. Podporované jsou objekty MiddlewareInterface a callable.", array("index"=>$index));
                }
                if (! $result instanceof ResponseInterface) {
                    throw new \DomainException("Middleware v zásobníku s indexem {index} nevrátilo objekt typu ResponseInterface.", array("index"=>$index));
                }
                return $result;
            });
        }
        return new RequestHandler(function () {
            throw new \LogicException("Nevyhodnocený request: zásobník middleware vyčerpán bez získání výstupu.");
        });
    }

}
