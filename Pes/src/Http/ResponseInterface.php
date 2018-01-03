<?php

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\Http;

use Psr\Http\Message\ResponseInterface as ResponsePsrInterface;

/**
 *
 * @author pes2704
 */
interface ResponseInterface extends ResponsePsrInterface {

    /**
     * Write data to the response body.
     *
     * Proxies to the underlying stream and writes the provided data to it.
     *
     * @param string $data
     * @return self
     */
    public function write($data);

    /*******************************************************************************
     * Response Helpers
     ******************************************************************************/

    /**
     * Redirect.
     *
     * This method prepares the response object to return an HTTP Redirect
     * response to the client.
     *
     * @param  string|UriInterface $url    The redirect destination.
     * @param  int|null            $status The redirect HTTP status code.
     * @return ResponseInterface
     */
    public function withRedirect($url, $status = null);

    /**
     * Json.
     *
     * This method prepares the response object to return an HTTP Json
     * response to the client.
     *
     * @param  mixed  $data   The data
     * @param  int    $status The HTTP status code.
     * @param  int    $encodingOptions Json encoding options
     * @throws \RuntimeException
     * @return ResponseInterface
     */
    public function withJson($data, $status = null, $encodingOptions = 0);
            
}
