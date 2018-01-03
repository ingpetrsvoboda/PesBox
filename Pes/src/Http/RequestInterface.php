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

use Psr\Http\Message\ServerRequestInterface;

/**
 *
 * @author pes2704
 */
interface RequestInterface extends ServerRequestInterface {
    
    /**
     * Register media type parser.
     *
     * @param string   $mediaType A HTTP media type (excluding content-type params).
     * @param callable $callable  A callable that returns parsed contents for media type.
     */
    public function registerMediaTypeParser($mediaType, callable $callable);
    
    /**
     * Force Body to be parsed again.
     *
     * @return self
     */
    public function reparseBody();
    
    /**
     * Get the original HTTP method (ignore override).
     *
     * @return string
     */
    public function getOriginalMethod();

    /*******************************************************************************
     * Parameters (e.g., POST and GET data)
     ******************************************************************************/

    /**
     * Fetch request parameter value from body or query string (in that order).
     *
     * @param  string $key The parameter key.
     * @param  string $default The default value.
     *
     * @return mixed The parameter value.
     */
    public function getParam($key, $default = null);

    /**
     * Fetch parameter value from request body.
     *
     * @param      $key
     * @param null $default
     *
     * @return null
     */
    public function getParsedBodyParam($key, $default = null);

    /**
     * Fetch parameter value from query string.
     *
     * @param      $key
     * @param null $default
     *
     * @return null
     */
    public function getQueryParam($key, $default = null);

    /**
     * Fetch assocative array of body and query string parameters.
     *
     * @return array
     */
    public function getParams();

    /**
     * Get request content type.
     *
     * @return string|null The request content type, if known
     */
    public function getContentType();

    /**
     * Get request media type, if known.
     *
     * @return string|null The request media type, minus content-type params
     */
    public function getMediaType();

    /**
     * Get request media type params, if known.
     *
     * @return array
     */
    public function getMediaTypeParams();
    
    /**
     * Get request content character set, if known.
     *
     * @return string|null
     */
    public function getContentCharset();

    /**
     * Get request content length, if known.
     *
     * @return int|null
     */
    public function getContentLength();
            
}
