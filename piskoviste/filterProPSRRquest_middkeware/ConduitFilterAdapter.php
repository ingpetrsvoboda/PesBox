<?php

// Sample implementation of a FilterInterface apadater for Conduit (UNTESTED)

use Phly\Conduit\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\FilterInterface as Filter;

class ConduitFilterAdapter implements MiddlewareInterface
{
    /**
     * @var \Psr\Http\Message\FilterInterface
     */
    private $filter;
    
    /**
     * @param \Psr\Http\Message\FilterInterface $filter
     */
    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        if ($this->filter->applyFilter($request, $response)) {
            return $next($request, $response);
        } else {
            return $response;
        }
    }
}
