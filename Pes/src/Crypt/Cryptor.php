<?php

namespace Pes\Cryptor;
/*
 * Copyright (C) http://php.net/manual/en/class.sessionhandler.php
 * Kopie příkladu z http://php.net/manual/en/class.sessionhandler.php
 */

/**
 * Description of Cryptor
 *
 * @author pes2704
 */
class CryptorAES256 implements CryptorInterface {
    
    public function __construct($key) {
        $this->key = $key;
    }

     /**
      * decrypt AES 256
      *
      * @param data $edata
      * @return decrypted data
      */
    function decrypt($edata) {
        $data = base64_decode($edata);
        $salt = substr($data, 0, 16);
        $ct = substr($data, 16);

        $rounds = 3; // depends on key length
        $data00 = $$this->key.$salt;
        $hash = array();
        $hash[0] = hash('sha256', $data00, true);
        $result = $hash[0];
        for ($i = 1; $i < $rounds; $i++) {
            $hash[$i] = hash('sha256', $hash[$i - 1].$data00, true);
            $result .= $hash[$i];
        }
        $this->key = substr($result, 0, 32);
        $iv  = substr($result, 32,16);

        return openssl_decrypt($ct, 'AES-256-CBC', $this->key, true, $iv);
      }

    /**
     * crypt AES 256
     *
     * @param data $data
     * @return base64 encrypted data
     */
    public function encrypt($data) {
        // Set a random salt
        $salt = openssl_random_pseudo_bytes(16);

        $salted = '';
        $dx = '';
        // Salt the key(32) and iv(16) = 48
        while (strlen($salted) < 48) {
          $dx = hash('sha256', $dx.$this->key.$salt, true);
          $salted .= $dx;
        }

        $key = substr($salted, 0, 32);
        $iv  = substr($salted, 32,16);

        $encrypted_data = openssl_encrypt($data, 'AES-256-CBC', $key, true, $iv);
        return base64_encode($salt . $encrypted_data);
    }
}
