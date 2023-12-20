<?php

namespace Account\Application\UseCase\DTO;

class ActivateAccountInput
{
    public function __construct(readonly string $verificationCode)
    {
    }
}
