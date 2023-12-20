<?php

namespace Account\Tests\Unit;

use Account\Domain\PlainPassword;
use PHPUnit\Framework\TestCase;

class PlainPasswordTest extends TestCase
{
    public function testCreate()
    {
        $password = PlainPassword::create("test");
        $this->assertEquals("test", $password->value);
    }

    public function testRestore()
    {
        $password = PlainPassword::restore("test", "");
        $this->assertEquals("test", $password->value);
    }

    public function testValidate()
    {
        $password = PlainPassword::create("test");
        $this->assertTrue($password->validate("test"));
    }

    public function testGetValue()
    {
        $password = PlainPassword::create("test");
        $this->assertEquals("test",$password->getValue());
    }
}