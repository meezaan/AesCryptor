<?php

namespace Meezaan\Aescryptor\Tests\Unit;

use Meezaan\Aescryptor\Generate;
use Meezaan\Aescryptor\Aes;
use PHPUnit\Framework\TestCase;

class AesTest extends TestCase
{
    private string $secret = "SomeSecret";

    public function testEncryptDecrypt()
    {
        $key = Generate::key();
        
        $aes = new Aes($key);
        
        $encrypted = $aes->encrypt($this->secret);
        $this->assertNotEquals($this->secret, $encrypted);
        
        $decrypted = $aes->decrypt($encrypted);
        $this->assertEquals($this->secret, $decrypted);
    }
   

}
