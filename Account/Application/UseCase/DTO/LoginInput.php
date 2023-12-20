<?php

namespace Account\Application\UseCase\DTO;

class LoginInput
{
    public function __construct(
        readonly string $email,
        readonly string $password
    )
    {
    }
}