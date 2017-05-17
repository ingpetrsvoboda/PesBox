<?php

namespace Psr\Http\Message;

/**
 * Representation of a filter being applied to a request/response pair
 * while processing an HTTP request.
 *
 * Each filter decides autonomously whether or not to delegate control
 * to the the next filter instance in the chain - it returns TRUE or FALSE
 * indicating whether or not to continue with the next filter.
 * 
 * Note that both $request and $response are passed by reference - the
 * objects themselves are immutable, but $request and $response work both
 * as arguments and (optionally) as return values providing request/response
 * arguments for the next filter.
 */
interface FilterInterface
{
    /**
     * @param ServerRequestInterface &$request the request being processed
     * @param ResponseInterface &$response     the response being generated
     *
     * @return bool true to continue; false to stop processing the filter chain
     */
    public function applyFilter(ServerRequestInterface &$request, ResponseInterface &$response);
}
