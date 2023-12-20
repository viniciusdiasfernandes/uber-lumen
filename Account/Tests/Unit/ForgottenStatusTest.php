<?php

namespace Account\Tests\Unit;

use Account\Domain\Account;
use Account\Domain\ActiveStatus;
use Account\Domain\ForgottenStatus;
use Account\Domain\StatusEnum;
use Exception;
use PHPUnit\Framework\TestCase;

class ForgottenStatusTest extends TestCase
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
        $activeStatus = new ForgottenStatus($account);
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
        $activeStatus = new ForgottenStatus($account);
        $this->expectException(Exception::class);
        $activeStatus->active();
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
        $activeStatus = new ForgottenStatus($account);
        $this->expectException(Exception::class);
        $activeStatus->forget();
    }
}