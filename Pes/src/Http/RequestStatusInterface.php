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

/**
 *
 * @author pes2704
 */
interface RequestStatusInterface {

    /**
     * Does this request use a given method?
     *
     * @param  string $method HTTP method
     * @return bool
     */
    public function isMethod($method);

    /**
     * Is this a GET request?
     *
     * @return bool
     */
    public function isGet();

    /**
     * Is this a POST request?
     *
     * @return bool
     */
    public function isPost();

    /**
     * Is this a PUT request?
     *
     * @return bool
     */
    public function isPut();

    /**
     * Is this a PATCH request?
     *
     * @return bool
     */
    public function isPatch();

    /**
     * Is this a DELETE request?
     *
     * @return bool
     */
    public function isDelete();

    /**
     * Is this a HEAD request?
     *
     * @return bool
     */
    public function isHead();
    
    /**
     * Is this a OPTIONS request?
     *
     * @return bool
     */
    public function isOptions();
    /**
     * Is this an XHR request?
     *
     * @return bool
     */
    public function isXhr();
    
}
