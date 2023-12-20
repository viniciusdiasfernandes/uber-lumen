<?php

namespace Account\Tests\Unit;

use Account\Domain\Account;
use Account\Domain\ActiveStatus;
use Account\Domain\CreatedStatus;
use Account\Domain\ForgottenStatus;
use Account\Domain\StatusEnum;
use Account\Domain\StatusFactory;
use Exception;
use PHPUnit\Framework\TestCase;

class StatusFactoryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreateReturningCreatedStatus()
    {
        $account = Account::create(
            "Vinicius",
            "vinidiax@gmail.com",
            "889.269.220-81",
            "test",
            true,
            false
        );
        $status = StatusFactory::create($account, StatusEnum::Created);
        $this->assertInstanceOf(CreatedStatus::class, $status);
    }

    /**
     * @throws Exception
     */
    public function testCreateReturningActiveStatus()
    {
        $account = Account::create(
            "Vinicius",
            "vinidiax@gmail.com",
            "889.269.220-81",
            "test",
            true,
            false
        );
        $status = StatusFactory::create($account, StatusEnum::Active);
        $this->assertInstanceOf(ActiveStatus::class, $status);
    }

    /**
     * @throws Exception
     */
    public function testCreateReturningForgottenStatus()
    {
        $account = Account::create(
            "Vinicius",
            "vinidiax@gmail.com",
            "889.269.220-81",
            "test",
            true,
            false
        );
        $status = StatusFactory::create($account, StatusEnum::Forgotten);
        $this->assertInstanceOf(ForgottenStatus::class, $status);
    }

    /**
     * @throws Exception
     */
    public function testCreateThrowException()
    {
        $account = Account::create(
            "Vinicius",
            "vinidiax@gmail.com",
            "889.269.220-81",
            "test",
            true,
            false
        );
        $this->expectException(Exception::class);
        StatusFactory::create($account, "NonExistentStatus");
    }
}