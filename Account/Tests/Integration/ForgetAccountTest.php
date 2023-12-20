<?php

namespace Account\Tests\Integration;

use Account\Application\UseCase\DTO\ForgetAccountInput;
use Account\Application\UseCase\ForgetAccount;
use Account\Domain\Account;
use Account\Domain\StatusEnum;
use Account\Infra\Database\MySqlPromiseAdapter;
use Account\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use PHPUnit\Framework\TestCase;

class ForgetAccountTest extends TestCase
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
        $input = new ForgetAccountInput(
            accountId: $account->accountId
        );
        $forgetAccount = new ForgetAccount($accountRepository);
        $output = $forgetAccount->execute($input);
        $account = $accountRepository->getById($output->accountId);
        $this->assertEquals(StatusEnum::Forgotten, $account->getStatus());
    }

    /**
     * @throws Exception
     */
    public function testExecuteWhenAccountDoNotExists()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        $input = new ForgetAccountInput(
            accountId: "SOMERANDOMID"
        );
        $forgetAccount = new ForgetAccount($accountRepository);
        $this->expectException(Exception::class);
        $forgetAccount->execute($input);
    }
}