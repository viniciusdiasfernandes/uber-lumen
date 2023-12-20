<?php

namespace Account\Application\UseCase\DTO;

class SignupInput
{
    public function __construct(
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