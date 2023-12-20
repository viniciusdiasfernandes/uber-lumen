<?php

namespace Account\Tests\Integration;

use Account\Application\UseCase\DTO\GetAccountInput;
use Account\Application\UseCase\GetAccount;
use Account\Domain\Account;
use Account\Infra\Database\MySqlPromiseAdapter;
use Account\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use PHPUnit\Framework\TestCase;

class GetAccountTest extends TestCase
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
            email: "vinidiax".uniqid()."@gmail.com",
            cpf:"565.486.780-60",
            password: "test123",
            isPassenger: true,
            isDriver: false,
            carPlate: ""
        );
        $accountRepository->save($account);
        $getAccount = new GetAccount($accountRepository);
        $input = new GetAccountInput($account->accountId);
        $output = $getAccount->execute($input);
        $this->assertEquals($account->accountId, $output->accountId);
    }

    /**
     * @throws Exception
     */
    public function testExecuteWhenAccountDoNotExists()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        $getAccount = new GetAccount($accountRepository);
        $input = new GetAccountInput("000000000000000000000000");
        $this->expectException(Exception::class);
        $getAccount->execute($input);
    }
}