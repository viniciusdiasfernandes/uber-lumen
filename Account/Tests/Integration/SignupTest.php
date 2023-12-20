<?php

namespace Account\Tests\Integration;

use Account\Application\UseCase\DTO\SignupInput;
use Account\Application\UseCase\Signup;
use Account\Infra\Database\MySqlPromiseAdapter;
use Account\Infra\Queue\RabbitMQAdapter;
use Account\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use PHPUnit\Framework\TestCase;

class SignupTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testExecuteOnSuccess()
    {
        $mysqlAdapter = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($mysqlAdapter);
        $queue = new RabbitMQAdapter();
        $signup = new Signup($accountRepository, $queue);
        $input = new SignupInput(
            name: "Vinicius",
            email: "vinidiax".uniqid()."@gmail.com",
            cpf:"565.486.780-60",
            password: "test123",
            isPassenger: true,
            isDriver: false,
            carPlate: ""
        );
        $output = $signup->execute($input);
        $account = $accountRepository->getById($output->accountId);
        $this->assertEquals($input->name, $account->name);
        $this->assertEquals($input->email, $account->email->getValue());
        $this->assertEquals($input->cpf, $account->cpf->getValue());
        $this->assertEquals($input->isPassenger, $account->isPassenger);
        $this->assertEquals($input->isDriver, $account->isDriver);
        $this->assertEquals($input->carPlate, $account->carPlate);
        $this->assertTrue( $account->password->validate($input->password));
    }

    public function testExecuteEmailAlreadyExists()
    {
        $mysqlAdapter = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($mysqlAdapter);
        $queue = new RabbitMQAdapter();
        $signup = new Signup($accountRepository, $queue);
        $input = new SignupInput(
            name: "Vinicius",
            email: "vinidiax@gmail.com",
            cpf:"565.486.780-60",
            password: "test123",
            isPassenger: true,
            isDriver: false,
            carPlate: ""
        );
        $this->expectException(Exception::class);
        $signup->execute($input);
        $signup->execute($input);
    }
}