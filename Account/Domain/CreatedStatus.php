<?php

namespace Account\Domain;

use Exception;

class CreatedStatus extends Status
{
    public string $value;
    public function __construct(Account $account)
    {
        parent::__construct($account);
        $this->value = StatusEnum::Created;
    }

    /**
     * @throws Exception
     */
    public function create(): void
    {
       throw new Exception("Invalid status");
    }

    public function active(): void
    {
        $this->account->status = new ActiveStatus($this->account);
    }

    public function forget(): void
    {
        $this->account->status = new ForgottenStatus($this->account);
    }
}