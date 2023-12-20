<?php

namespace Account\Domain;

use Exception;

class ActiveStatus extends Status
{
    public string $value;
    public function __construct(Account $account)
    {
        parent::__construct($account);
        $this->value = StatusEnum::Active;
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

    public function forget(): void
    {
        $this->account->status = new ForgottenStatus($this->account);
    }
}