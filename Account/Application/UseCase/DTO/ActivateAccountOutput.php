<?php

namespace Account\Application\UseCase\DTO;

class ActivateAccountOutput
{
    public function __construct(readonly string $email)
    {
    }
}
