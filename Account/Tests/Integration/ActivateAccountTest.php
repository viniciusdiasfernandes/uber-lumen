<?php

namespace Account\Tests\Integration;

use Account\Application\UseCase\ActivateAccount;
use Account\Application\UseCase\DTO\ActivateAccountInput;
use Account\Domain\Account;
use Account\Infra\Database\MySqlPromiseAdapter;
use Account\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use PHPUnit\Framework\TestCase;

class ActivateAccountTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testExecuteOnSuccess()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        $account = Account::create(
            name: "Vinicius",
            email: "vinidiax" . uniqid() . "@gmail.com",
            cpf: "565.486.780-60",
            password: "test123",
            isPassenger: true,
            isDriver: false,
            carPlate: ""
        );
        $accountRepository->save($account);
        $activateAccount = new ActivateAccount($accountRepository);
        $input = new ActivateAccountInput($account->verificationCode);
        $output = $activateAccount->execute($input);
        $this->assertEquals($account->email->getValue(), $output->email);
    }

    public function testExecuteNonExistentVerificationCode()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        $activateAccount = new ActivateAccount($accountRepository);
        $input = new ActivateAccountInput("000000000000000000000000000000");
        $this->expectException(Exception::class);
        $activateAccount->execute($input);
    }
}