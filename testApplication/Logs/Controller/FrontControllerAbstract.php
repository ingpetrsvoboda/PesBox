<?php

/*
 * Copyright (C) 2018 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace TestApplication\Controller;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Description of FrontControllerAbstract
 *
 * @author pes2704
 */
class FrontControllerAbstract {

    /**
     *
     * @var ServerRequestInterface
     */
    protected $request;

    public function __construct(ServerRequestInterface $request) {
        $this->request = $request;
    }
}
