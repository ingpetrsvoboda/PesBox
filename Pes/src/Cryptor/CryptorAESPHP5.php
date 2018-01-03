<?php

namespace Pes\Cryptor;
/*
 * Copyright (C) http://php.net/manual/en/class.sessionhandler.php
 * Kopie příkladu z http://php.net/manual/en/class.sessionhandler.php
 */
    /**
     * Pro AES -128, -192, -256
     * Zdá se, že na délce moc nezáleží, 256 asi není bezpečnější než kratší díky "špatnému uspořádání bitů" ve variantě 256 (??)
     * Zřejmě nejvhodnější metody jsou AES-256-GCM (až od PHP 7.1), AES-256-CTR nebo AES-256-CBC, utčitě nebezpečná je varianta ECB.
     * Musí být náhodně generovaná iv pro každou zprávu!
     * Musí být ověřena integrita zprávy - mohlo dofít k manipulaci man in the middle - zprávu je třaba tzv. autentizovat. Přidává se 
     * ke zprávě Message Authentication Code (MAC) - řetězec, který závisí na zprávě a na klíči. MAC je třeba přidat taktp: 
     * Encrypt then MAC: encrypt the plaintext, compute the MAC of the ciphertext, and append the MAC of the ciphertext to the ciphertext.
     * Klíč - možná: you want binary strings, not human-readabale strings, for your keys - např. hex2bin('000102030405060708090a0b0c0d0e0f1011121314151617181‌​91a1b1c1d1e1f')
     * 
     * https://stackoverflow.com/questions/9262109/simplest-two-way-encryption-using-php (Scott Arciszewski)
     * https://tonyarcieri.com/all-the-crypto-code-youve-ever-written-is-probably-broken
     * https://crypto.stackexchange.com/questions/6523/what-is-the-difference-between-mac-and-hmac
     * knihovna: https://github.com/defuse/php-encryption
     */
/**
 * Description of Cryptor
 *
 * @author pes2704
 */
class CryptorAESPHP5 implements CryptorInterface {
    
    public function __construct($key) {
        $this->key = $key;
    }

    /**
     * Crypt AES 256
     * Šifruje vstupní data metodou AES-256-CTR, salt generuje interně, výstup kóduje base64. Klíč je zadán v konstruktoru. 
     * Používá funkci openssl_encrypt().
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

        $encrypted_data = openssl_encrypt($data, 'AES-256-CTR', $this->key, true, $iv);
        return base64_encode($salt . $encrypted_data);
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

        return openssl_decrypt($ct, 'AES-256-CTR', $this->key, true, $iv);  //původně AES-256-CBC
      }
}
