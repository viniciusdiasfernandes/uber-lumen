<?php

namespace Account\Tests\Integration;

use Account\Application\UseCase\DTO\UpdateAccountInput;
use Account\Application\UseCase\UpdateAccount;
use Account\Domain\Account;
use Account\Infra\Database\MySqlPromiseAdapter;
use Account\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use PHPUnit\Framework\TestCase;

class UpdateAccountTest extends TestCase
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
        $input = new UpdateAccountInput(
            accountId: $account->accountId,
            name: "Vinicius UPDATED",
            email: $account->email->getValue(),
            cpf: $account->cpf->getValue(),
            password: "test123",
            carPlate: ""
        );
        $updateAccount = new UpdateAccount($accountRepository);
        $output = $updateAccount->execute($input);
        $account = $accountRepository->getById($output->accountId);
        $this->assertEquals($input->name, $account->name);
        $this->assertEquals($input->email, $account->email->getValue());
        $this->assertEquals($input->cpf, $account->cpf->getValue());
        $this->assertEquals($input->carPlate, $account->carPlate);
        $this->assertTrue($account->password->validate($input->password));
    }

    /**
     * @throws Exception
     */
    public function testExecuteWhenAccountDoNotExists()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        $input = new UpdateAccountInput(
            accountId: "SOMERANDOMID",
            name: "Vinicius",
            email: "teste@test.com",
            cpf: "565.486.780-60",
            password: "test123",
            carPlate: ""
        );
        $updateAccount = new UpdateAccount($accountRepository);
        $this->expectException(Exception::class);
        $updateAccount->execute($input);
    }

    /**
     * @throws Exception
     */
    public function testExecuteWhenEmailIsInUse()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        $account1 = Account::create(
            name: "Vinicius login",
            email: "vinidiax" . uniqid() . "@gmail.com",
            cpf: "565.486.780-60",
            password: "test123",
            isPassenger: true,
            isDriver: false,
            carPlate: ""
        );
        $accountRepository->save($account1);
        $account2 = Account::create(
            name: "Vinicius login",
            email: "vinidiax" . uniqid() . "@gmail.com",
            cpf: "565.486.780-60",
            password: "test123",
            isPassenger: true,
            isDriver: false,
            carPlate: ""
        );
        $accountRepository->save($account2);
        $input = new UpdateAccountInput(
            accountId: $account2->accountId,
            name: "Vinicius",
            email: $account1->email->getValue(),
            cpf: $account2->cpf->getValue(),
            password: "test123",
            carPlate: ""
        );
        $updateAccount = new UpdateAccount($accountRepository);
        $this->expectException(Exception::class);
        $updateAccount->execute($input);
    }
}