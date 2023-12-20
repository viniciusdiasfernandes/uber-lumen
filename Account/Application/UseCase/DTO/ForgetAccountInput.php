<?php

namespace Account\Application\UseCase\DTO;

class ForgetAccountInput
{
    public function __construct(readonly string $accountId)
    {
    }
}
