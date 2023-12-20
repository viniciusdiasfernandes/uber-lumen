<?php

namespace Account\Tests\Unit;

use Account\Domain\PasswordFactory;
use Account\Domain\StatusEnum;
use Account\Domain\Account;
use Exception;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreate()
    {
        $account = Account::create("Vinicius", "vinidiax@gmail.com", "889.269.220-81", "test", true, false);
        $this->assertNotNull($account->accountId);
        $this->assertEquals("Vinicius", $account->name);
        $this->assertEquals("vinidiax@gmail.com", $account->email->getValue());
        $this->assertEquals("889.269.220-81", $account->cpf->getValue());
        $this->assertTrue( $account->password->validate("test"));
        $this->assertTrue($account->isPassenger);
        $this->assertFalse($account->isDriver);
        $this->assertNull($account->carPlate);
    }

    /**
     * @throws Exception
     */
    public function testRestore()
    {
        $account = Account::restore("test", "Vinicius", "vinidiax@gmail.com", "889.269.220-81",PasswordFactory::create("hash","test")->getValue(), StatusEnum::Created,true, false,"123456");
        $this->assertEquals("test", $account->accountId);
        $this->assertEquals("Vinicius", $account->name);
        $this->assertEquals("vinidiax@gmail.com", $account->email->getValue());
        $this->assertEquals("889.269.220-81", $account->cpf->getValue());
        $this->assertTrue($account->password->validate("test"));
        $this->assertTrue($account->isPassenger);
        $this->assertFalse($account->isDriver);
        $this->assertNull($account->carPlate);
    }
}