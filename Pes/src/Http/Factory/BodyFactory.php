<?php

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\Http\Factory;

use Pes\Http\Body;

/**
 * Create instances Body.
 */
class BodyFactory {

    /**
     * 
     * @param string $content
     * @return Body
     */
    public static function createFromString($content = '')
    {
        $stream = self::createFromFile('php://temp', 'r+');
        $stream->write($content);
        $stream->rewind();
        return $stream;
    }

    /**
     * 
     * @param string $fileName
     * @param string $mode
     * @return Body
     */
    public static function createFromFile($fileName, $mode = 'r')
    {
        return self::createFromResource(fopen($fileName, $mode));
    }

    /**
     * 
     * @param resource $resource
     * @return Body
     */
    public static function createFromResource($resource)
    {
        return new Body($resource);
    }
}
