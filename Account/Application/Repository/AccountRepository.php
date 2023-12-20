<?php

namespace Account\Application\Repository;

use Account\Domain\Account;

interface AccountRepository
{
    public function getById(string $accountId): ?Account;

    public function getByEmail(string $email): ?Account;

    public function save(Account $account): void;

    public function update(Account $account): void;

    public function getByVerificationCode(string $verificationCode): ?Account;

}