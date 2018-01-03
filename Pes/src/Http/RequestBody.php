<?php
/**
 * upraveno z:
 * Slim Framework (http://slimframework.com)
 *
 * @link      https://github.com/slimphp/Slim
 * @copyright Copyright (c) 2011-2016 Josh Lockhart
 * @license   https://github.com/slimphp/Slim/blob/3.x/LICENSE.md (MIT License)
 */
namespace Pes\Http;

/**
 * Provides a PSR-7 implementation of a reusable raw request body. Použito např. v RequestPsr::createFromEnvironment.
 */
class RequestBody extends Body
{
    /**
     * Create a new RequestBody.
     */
    public function __construct()
    {
        $stream = fopen('php://temp', 'w+');
        // function stream_copy_to_stream($source, $dest, int $maxlength = -1, int $offset = 0) - * @return int the total count of bytes copied.
        // maxlength určuje jak velkou paměť funkce spotřebuje
        // pro offset=0 stream_copy_to_stream udělá kopii od aktuální pozice zdrojového streamu - tady to nevadí, zdroj byl právě otevřen fopen, 
        // ale mohl by to být problém, pokud bys takto kopíroval body v Response (! rewind($stream) PŘED kopírováním)
        stream_copy_to_stream(fopen('php://input', 'r'), $stream);  
        rewind($stream);  

        parent::__construct($stream);
    }
}
