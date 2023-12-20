<?php

namespace Account\Application\UseCase\DTO;

class UpdateAccountInput
{
    public function __construct(
        readonly string $accountId,
        readonly string  $name,
        readonly string  $email,
        readonly string  $cpf,
        readonly string  $password,
        readonly ?string $carPlate,

    )
    {
    }
}