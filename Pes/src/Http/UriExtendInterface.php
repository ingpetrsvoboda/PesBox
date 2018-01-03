<?php

/*
 * Třída Uri má rozsáhlejší API než \Psr\Http\Message\UriInterface;
 */

namespace Pes\Http;

/**
 *
 * @author pes2704
 */
interface UriExtendInterface extends \Psr\Http\Message\UriInterface {
    public function getBasePath();
    public function withBasePath($basePath);
    public function getBaseUrl();    
}
