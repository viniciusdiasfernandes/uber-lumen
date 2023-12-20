<?php

namespace Account\Infra\Repository;

use Account\Application\Repository\AccountRepository;
use Account\Domain\Account;
use Account\Infra\Database\Connection;
use Exception;

class AccountRepositoryDatabase implements AccountRepository
{
    public function __construct(readonly Connection $connection)
    {
    }

    /**
     * @throws Exception
     */
    public function getById(string $accountId): ?Account
    {
        $account = $this->connection->query("SELECT * FROM account WHERE account_id = '{$accountId}'")->fetch_object();
        if (!$account) return null;
        return Account::restore(
            accountId: $account->account_id,
            name: $account->name,
            email: $account->email,
            cpf: $account->cpf,
            password: $account->password,
            status: $account->status,
            isPassenger: $account->is_passenger,
            isDriver: $account->is_driver,
            verificationCode: $account->verification_code,
            carPlate: $account->car_plate
        );
    }

    /**
     * @throws Exception
     */
    public function getByEmail(string $email): ?Account
    {
        $account = $this->connection->query("SELECT * FROM account WHERE email = '{$email}'")->fetch_object();
        if (!$account) return null;
        return Account::restore(
            accountId: $account->account_id,
            name: $account->name,
            email: $account->email,
            cpf: $account->cpf,
            password: $account->password,
            status: $account->status,
            isPassenger: $account->is_passenger,
            isDriver: $account->is_driver,
            verificationCode: $account->verification_code,
            carPlate: $account->car_plate
        );
    }

    /**
     * @throws Exception
     */
    public function getByVerificationCode(string $verificationCode): ?Account
    {
        $account = $this->connection->query("SELECT * FROM account WHERE verification_code = '{$verificationCode}' AND status = 'created'")->fetch_object();
        if (!$account) return null;
        return Account::restore(
            accountId: $account->account_id,
            name: $account->name,
            email: $account->email,
            cpf: $account->cpf,
            password: $account->password,
            status: $account->status,
            isPassenger: $account->is_passenger,
            isDriver: $account->is_driver,
            verificationCode: $account->verification_code,
            carPlate: $account->car_plate
        );
    }

    public function save(Account $account): void
    {
        $isPassenger = (int)$account->isPassenger;
        $isDriver = (int)$account->isDriver;
        $this->connection->query("INSERT INTO account (account_id, name, email, cpf, car_plate, is_passenger, is_driver, password, status, password_algorithm, salt, verification_code)
        VALUES ('{$account->accountId}','{$account->name}','{$account->email->getValue()}','{$account->cpf->getValue()}','{$account->carPlate}',{$isPassenger},{$isDriver},'{$account->password->getValue()}','{$account->status->value}','','', '{$account->verificationCode}')");
    }

    public function update(Account $account): void
    {
        $isPassenger = (int)$account->isPassenger;
        $isDriver = (int)$account->isDriver;
        $this->connection->query("UPDATE account SET name = '{$account->name}',email = '{$account->email->getValue()}',cpf = '{$account->cpf->getValue()}',car_plate = '{$account->carPlate}', is_passenger = {$isPassenger}, is_driver = {$isDriver}, password = '{$account->password->getValue()}', status = '{$account->status->value}', password_algorithm = '', salt = '' WHERE account_id = '{$account->accountId}'");
    }
}