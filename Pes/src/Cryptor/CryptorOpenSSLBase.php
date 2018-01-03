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
 * Upraveno z:
 * https://github.com/ioncube/php-openssl-cryptor/blob/master/cryptor.php
 * 
 * Třída pro šifrování a dešifrování. Používá openssl encrypt/decrypt funkce. 
 *
 * Available under the MIT License
 *
 * The MIT License (MIT)
 * Copyright (c) 2016 ionCube Ltd.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of
 * the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO
 * THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT
 * OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
class CryptorOpenSSLBase implements CryptorInterface {
    private $cipherMethod;
    private $hashMethod;
    private $ivLength;
    private $encoding;
    
    const CIPHER_METHOD = 'aes-256-ctr';
    const HASH_METHOD = 'sha256';
    const FORMAT_RAW = 0;
    const FORMAT_B64 = 1;
    const FORMAT_HEX = 2;
    
    /**
     * Konstruktor bázové třídy - defaultně používá aes256 šifrování, sha256 pro hash klíče base64 kódování výstupního řetězce.
     * @param string $cipherMethod Šifrovací metoda.
     * @param string $hashMethod   Metoda pro hashování klíče.
     * @param [type] $encoding         Kódování výstupního řetězce.
     * @throws \UnexpectedValueException  Neznámá metoda šifrování nebo hashování
     */
    public function __construct($cipherMethod = self::CIPHER_METHOD, $hashMethod = self::HASH_METHOD, $encoding = self::FORMAT_B64) {
        $this->cipherMethod = $cipherMethod;
        $this->hashMethod = $hashMethod;
        $this->encoding = $encoding;
        if (!in_array($cipherMethod, openssl_get_cipher_methods(true))) {
            throw new \UnexpectedValueException(get_called_class()." - openssl nepodporuje zadanou metodu šifrování {$cipherMethod}");
        }
        if (!in_array($hashMethod, openssl_get_md_methods(true))) {
            throw new \UnexpectedValueException(get_called_class()." - openssl nepodporuje zadanou metodu hashování {$hashMethod}");
        }
        $this->ivLength = openssl_cipher_iv_length($cipherMethod);
    }
    /**
     * Encrypt a string.
     * @param  string $in  String to encrypt.
     * @param  string $key Encryption key.
     * @param  int $encoding Optional override for the output encoding. One of FORMAT_RAW, FORMAT_B64 or FORMAT_HEX.
     * @return string      The encrypted string.
     */
    public function encryptString($in, $key, $encoding = self::FORMAT_B64)
    {
        // Build an initialisation vector
        $iv = openssl_random_pseudo_bytes($this->ivLength, $isStrongCrypto);
        if (!$isStrongCrypto) {
            throw new \Exception("Cryptor::encryptString() - Not a strong key");
        }
        // Hash the key
        $keyhash = openssl_digest($key, $this->hashMethod, true);
        // and encrypt
        $opts =  OPENSSL_RAW_DATA;
        $encrypted = openssl_encrypt($in, $this->cipherMethod, $keyhash, $opts, $iv);
        if ($encrypted === false) {
            throw new \Exception('Cryptor::encryptString() - Encryption failed: ' . openssl_error_string());
        }
        // The result comprises the IV and encrypted data
        $res = $iv . $encrypted;
        // and format the result if required.
        if ($encoding == Cryptor::FORMAT_B64) {
            $res = base64_encode($res);
        } elseif ($encoding == Cryptor::FORMAT_HEX) {
            $res = unpack('H*', $res)[1];
        }
        return $res;
    }
    /**
     * Decrypt a string.
     * @param  string $in  String to decrypt.
     * @param  string $key Decryption key.
     * @param  int $fmt Optional override for the input encoding. One of FORMAT_RAW, FORMAT_B64 or FORMAT_HEX.
     * @return string      The decrypted string.
     */
    public function decryptString($in, $key, $fmt = null)
    {
        if ($fmt === null)
        {
            $fmt = $this->encoding;
        }
        $raw = $in;
        // Restore the encrypted data if encoded
        if ($fmt == Cryptor::FORMAT_B64)
        {
            $raw = base64_decode($in);
        }
        else if ($fmt == Cryptor::FORMAT_HEX)
        {
            $raw = pack('H*', $in);
        }
        // and do an integrity check on the size.
        if (strlen($raw) < $this->ivLength)
        {
            throw new \Exception('Cryptor::decryptString() - ' .
                'data length ' . strlen($raw) . " is less than iv length {$this->ivLength}");
        }
        // Extract the initialisation vector and encrypted data
        $iv = substr($raw, 0, $this->ivLength);
        $raw = substr($raw, $this->ivLength);
        // Hash the key
        $keyhash = openssl_digest($key, $this->hashMethod, true);
        // and decrypt.
        $opts = OPENSSL_RAW_DATA;
        $res = openssl_decrypt($raw, $this->cipherMethod, $keyhash, $opts, $iv);
        if ($res === false)
        {
            throw new \Exception('Cryptor::decryptString - decryption failed: ' . openssl_error_string());
        }
        return $res;
    }
}


$algo  = 'aes-256-gcm';
$iv    = random_bytes(openssl_cipher_iv_length($algo));
$key   = random_bytes(32); // 256 bit
$email = 'This is the secret message!';
$aad   = 'From: foo@domain.com, To: bar@domain.com';
$ciphertext = openssl_encrypt(
    $email,
    $algo,
    $key,
    OPENSSL_RAW_DATA,
    $iv,
    $tag,
    $aad
);
// Change 1 bit in additional authenticated data
// $i = rand(0, mb_strlen($aad, '8bit') - 1);
// $aad[$i] = $aad[$i] ^ chr(1);
$decrypt = openssl_decrypt(
    $ciphertext,
    $algo,
    $key,
    OPENSSL_RAW_DATA,
    $iv,
    $tag,
    $aad
);
if (false === $decrypt) {
    throw new Exception(sprintf(
        "OpenSSL error: %s", openssl_error_string()
    ));
}
printf ("Decryption %s\n", $email === $decrypt ? 'Ok' : 'Failed');

#################

while ($msg = openssl_error_string())
    echo $msg . "<br />\n";