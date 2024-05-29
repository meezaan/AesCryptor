<?php

namespace Meezaan\Aescryptor;

class Aes {
    
    public const AES_256_CBC = "aes-256-cbc";
    
    /**
     * A 256-bit encryption key in hex. Store this in a secure vault somewhere.
     */
    private string $key;
    
    /**
     * Initialisation Vector in hex
     */
    private string $iv;
    
    /**
     * Can be one of OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING | 0 
     */
    private int $options;
    
    public function __construct(string $key, int $options = null)
    {
        $this->key = $this->convertToBin($key);
        $this->iv = $this->convertToBin(Generate::iv());
        if ($options === null) {
            $this->options = 0;
        }
    }
    
    /**
     * @param string $data Unencrypted String
     */
    public function encrypt(string $data): string
    {
        $encData = openssl_encrypt($data, self::AES_256_CBC, $this->key, $this->options, $this->iv);
        
        return $encData . ':::' . base64_encode($this->iv);
    }
    
    /**
     * @param string $data Encrypted String
     */
    public function decrypt(string $data): string
    {
        $parts = explode(':::', $data);
        
        return openssl_decrypt($parts[0], self::AES_256_CBC, $this->key, $this->options, base64_decode($parts[1]));
    }
    
    public function getKey(): string
    {
        return $this->key;
    }

    public function getIv(): string
    {
        return $this->iv;
    }

    /**
     * Converts hex strings to binary data
     */
    private function convertToBin(string $data): string
    {
        if (ctype_xdigit($data)) {
            // This means we have $data is hex
            return hex2bin($data);
        }

        // Otherwise we already have binary
        return $data;
    }

    
    
}