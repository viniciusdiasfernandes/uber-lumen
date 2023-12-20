<?php

namespace Account\Domain;

use Exception;

class Account
{
    public Status $status;

    /**
     * @throws Exception
     */
    private function __construct(
        readonly string   $accountId,
        readonly string   $name,
        readonly Email    $email,
        readonly Cpf      $cpf,
        readonly Password $password,
        string            $status,
        readonly bool     $isPassenger,
        readonly bool     $isDriver,
        readonly string   $verificationCode,
        readonly ?string  $carPlate = null
    )
    {
        $this->status = StatusFactory::create($this, $status);
    }

    /**
     * @throws Exception
     */
    public static function create(string $name, string $email, string $cpf, string $password, bool $isPassenger, bool $isDriver, string $carPlate = null): Account
    {
        $accountId = uniqid();
        $status = StatusEnum::Created;
        $verificationCode = uniqid();
        return new Account($accountId, $name, new Email($email), new Cpf($cpf), PasswordFactory::create("hash", $password), $status, $isPassenger, $isDriver, $verificationCode, $carPlate);
    }

    /**
     * @throws Exception
     */
    public static function restore(string $accountId, string $name, string $email, string $cpf, string $password, string $status, bool $isPassenger, bool $isDriver, string $verificationCode, string $carPlate = null): Account
    {
        return new Account($accountId, $name, new Email($email), new Cpf($cpf), PasswordFactory::create("hash", $password)::restore($password), $status, $isPassenger, $isDriver, $verificationCode, $carPlate);
    }

    public function active(): void
    {
        $this->status->active();
    }

    public function forget(): void
    {
        $this->status->forget();
    }

    public function getStatus(): string
    {
        return $this->status->value;
    }
}