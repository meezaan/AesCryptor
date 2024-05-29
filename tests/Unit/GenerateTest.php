<?php

namespace Meezaan\Aescryptor\Tests\Unit;

use Meezaan\Aescryptor\Generate;
use PHPUnit\Framework\TestCase;

class GenerateTest extends TestCase
{
    public function testKeyGeneration()
    {
        $key = Generate::key();
        $this->assertEquals(32, strlen($key));
    }
    
public function testIvGeneration()
    {
        $iv = Generate::iv();
        $this->assertIsString($iv);
        $this->assertEquals(16, strlen($iv));
    }
}

