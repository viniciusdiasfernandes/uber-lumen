<?php

namespace Account\Application\UseCase\DTO;

class UpdateAccountOutput
{
    public function __construct(
        readonly string $accountId,
        readonly string  $name,
        readonly string  $email,
        readonly string  $cpf,
        readonly string  $password,
        readonly bool    $isPassenger,
        readonly bool    $isDriver,
        readonly ?string $carPlate,

    )
    {
    }
}