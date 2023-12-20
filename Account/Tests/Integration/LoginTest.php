<?php

namespace Account\Tests\Integration;

use Account\Application\UseCase\DTO\LoginInput;
use Account\Application\UseCase\Login;
use Account\Domain\Account;
use Account\Infra\Database\MySqlPromiseAdapter;
use Account\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testExecute()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        $account = Account::create(
            name: "Vinicius login",
            email: "vinidiax" . uniqid() . "@gmail.com",
            cpf: "565.486.780-60",
            password: "test123",
            isPassenger: true,
            isDriver: false,
            carPlate: ""
        );
        $accountRepository->save($account);
        $loginInput = new LoginInput(
            email: $account->email->getValue(),
            password: "test123"
        );
        $login = new Login($accountRepository);
        $output = $login->execute($loginInput);
        $this->assertEquals($account->email->getValue(), $output->accountEmail);
    }

    /**
     * @throws Exception
     */
    public function testExecuteWithNonExistentEmail()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        $loginInput = new LoginInput(
            email: "nonexistente@test.com",
            password: "test123"
        );
        $login = new Login($accountRepository);
        $this->expectException(Exception::class);
        $login->execute($loginInput);
    }

    /**
     * @throws Exception
     */
    public function testExecuteWithWrongPassword()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        $account = Account::create(
            name: "Vinicius login",
            email: "vinidiax" . uniqid() . "@gmail.com",
            cpf: "565.486.780-60",
            password: "test123",
            isPassenger: true,
            isDriver: false,
            carPlate: ""
        );
        $accountRepository->save($account);
        $loginInput = new LoginInput(
            email: $account->email->getValue(),
            password: "WRONGPASSWORD"
        );
        $login = new Login($accountRepository);
        $this->expectException(Exception::class);
        $login->execute($loginInput);
    }
}