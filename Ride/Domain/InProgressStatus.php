<?php

namespace Ride\Domain;

use Exception;

class InProgressStatus extends Status
{
    public string $value;
    public function __construct(Ride $ride)
    {
        parent::__construct($ride);
        $this->value = StatusEnum::InProgress;
    }

    /**
     * @throws Exception
     */
    public function request(): void
    {
        throw new Exception("Invalid ride status");
    }

    /**
     * @throws Exception
     */
    public function accept(): void
    {
        throw new Exception("Invalid ride status");
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        throw new Exception("Invalid ride status");
    }

    /**
     * @throws Exception
     */
    public function finish(): void
    {
        $this->ride->status = new CompletedStatus($this->ride);
    }

    /**
     * @throws Exception
     */
    public function cancel(): void
    {
        throw new Exception("Invalid ride status");
    }
}
