<?php

namespace Account\Application\UseCase\DTO;

class SignupOutput
{
    public function __construct(
        readonly string $accountId,
        readonly string $verificationCode
    )
    {
    }
}