<?php

namespace Account\Application\UseCase\DTO;

class LoginOutput
{
    public function __construct(readonly string $accountId, readonly string $accountEmail)
    {
    }
}