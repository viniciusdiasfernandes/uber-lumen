<?php

namespace Account\Domain;

use Exception;

class StatusFactory
{
    /**
     * @throws Exception
     */
    public static function create(Account $account, string $status): Status
    {
        if($status === StatusEnum::Created) return new CreatedStatus($account);
        if($status === StatusEnum::Active) return new ActiveStatus($account);
        if($status === StatusEnum::Forgotten) return new ForgottenStatus($account);
        throw new Exception("Invalid status");
    }
}