<?php

namespace Account\Domain;

use Exception;

class ForgottenStatus extends Status
{
    public string $value;
    public function __construct(Account $account)
    {
        parent::__construct($account);
        $this->value = StatusEnum::Forgotten;
    }

    /**
     * @throws Exception
     */
    public function create(): void
    {
       throw new Exception("Invalid status");
    }

    /**
     * @throws Exception
     */
    public function active(): void
    {
        throw new Exception("Invalid status");
    }

    /**
     * @throws Exception
     */
    public function forget(): void
    {
        throw new Exception("Invalid status");
    }
}