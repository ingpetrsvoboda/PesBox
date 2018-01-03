<?php

/*
 * Copyright (C) http://php.net/manual/en/class.sessionhandler.php
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\Session;

use Pes\Cryptor\CryptorInterface;

/**
 * Description of EncryptedHandler
 *
 * @author pes2704
 */
class EncryptedHandler  extends \SessionHandler
{
    /**
     *
     * @var type 
     */
    private $cryptor;

    public function __construct(CryptorInterface $cryptor) {
        $this->cryptor = $cryptor;
    }

    public function read($id) {
        $data = parent::read($id);
        if (!$data) {
            return "";
        } else {
            return $this->cryptor->decrypt($data);
        }
    }

    public function write($id, $data) {
        return parent::write($id, $this->cryptor->encrypt($data));
    }
}
