<?php

namespace Account\Application\UseCase\DTO;

class ForgetAccountOutput
{
    public function __construct(readonly string $accountId, readonly string $status)
    {
    }
}
