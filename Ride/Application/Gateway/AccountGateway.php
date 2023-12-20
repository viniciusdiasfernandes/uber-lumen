<?php

namespace Ride\Application\Gateway;

interface AccountGateway
{
    public function getById(string $accountId): string;
    public function signup(array $data): string;
}
