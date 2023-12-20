<?php

namespace Account\Tests\Unit;

use Account\Domain\HashPassword;
use Account\Domain\PasswordFactory;
use Account\Domain\PlainPassword;
use Exception;
use PHPUnit\Framework\TestCase;

class PasswordFactoryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreateReturningPlain()
    {
        $password = PasswordFactory::create("plain", "test");
        $this->assertInstanceOf(PlainPassword::class, $password);
    }

    /**
     * @throws Exception
     */
    public function testCreateReturningHash()
    {
        $password = PasswordFactory::create("hash", "test");
        $this->assertInstanceOf(HashPassword::class, $password);
    }

    /**
     * @throws Exception
     */
    public function testCreateThrowException()
    {
        $this->expectException(Exception::class);
        PasswordFactory::create("randomValue", "test");
    }
}