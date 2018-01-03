<?php

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\Cryptor;

/**
 * Description of CryptorAESPHP71
 *
 * @author pes2704
 */
class CryptorAESPHP71 implements CryptorInterface {
    
    public function __construct($key) {
        ;
    }
    public function encrypt($plaintext) {
        //$key should have been previously generated in a cryptographically safe way, like openssl_random_pseudo_bytes
        $cipher = "aes-128-gcm";
        if (in_array($cipher, openssl_get_cipher_methods())) {
            $ivlen = openssl_cipher_iv_length($cipher);
            $iv = openssl_random_pseudo_bytes($ivlen);
            $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);
            //store $cipher, $iv, and $tag for decryption later
            echo $original_plaintext."\n";
        } else {
            throw new \LogicException('Není podporována metoda '.$cipher.'.');
        }
    }
    public function decrypt($ciphertext) {
            $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
    }
}
