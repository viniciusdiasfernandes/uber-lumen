<?php

namespace Account\Tests\Unit;

use Account\Domain\Account;
use Account\Domain\CreatedStatus;
use Account\Domain\StatusEnum;
use Exception;
use PHPUnit\Framework\TestCase;

class CreatedStatusTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreate()
    {
        $account = Account::create(
            "Vinicius",
            "vinidiax@gmail.com",
            "889.269.220-81",
            "test",
            true,
            false
        );
        $activeStatus = new CreatedStatus($account);
        $this->expectException(Exception::class);
        $activeStatus->create();
    }

    /**
     * @throws Exception
     */
    public function testActive()
    {
        $account = Account::create(
            "Vinicius",
            "vinidiax@gmail.com",
            "889.269.220-81",
            "test",
            true,
            false
        );
        $activeStatus = new CreatedStatus($account);
        $activeStatus->active();
        $this->assertEquals(StatusEnum::Active, $account->getStatus());
    }

    /**
     * @throws Exception
     */
    public function testForget()
    {
        $account = Account::create(
            "Vinicius",
            "vinidiax@gmail.com",
            "889.269.220-81",
            "test",
            true,
            false
        );
        $activeStatus = new CreatedStatus($account);
        $activeStatus->forget();
        $this->assertEquals(StatusEnum::Forgotten, $account->getStatus());
    }
}