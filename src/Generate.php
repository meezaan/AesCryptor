<?php

namespace Meezaan\Aescryptor;

class Generate {
    /**
     * Generates an initialisation vector string
     */
    public static function iv(): string
    {
        return bin2hex(openssl_random_pseudo_bytes(openssl_cipher_iv_length(Aes::AES_256_CBC)));
    }
    
    /**
     * Generates a 256-bit encryption key
     */
    public static function key(): string
    {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }
}