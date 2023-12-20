<?php

namespace Account\Application\UseCase\DTO;

class GetAccountInput
{
    public function __construct(readonly string $accountId)
    {
    }
}