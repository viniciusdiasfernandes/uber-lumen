<?php

namespace Ride\Domain;

use Exception;

class RequestedStatus extends Status
{
    public string $value;

    public function __construct(Ride $ride)
    {
        parent::__construct($ride);
        $this->value = StatusEnum::Requested;
    }

    /**
     * @throws Exception
     */
    public function request(): void
    {
        throw new Exception("Invalid ride status");
    }

    public function accept(): void
    {
        $this->ride->status = new AcceptedStatus($this->ride);
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
        throw new Exception("Invalid ride status");
    }

    /**
     * @throws Exception
     */
    public function cancel(): void
    {
        $this->ride->status = new CancelledStatus($this->ride);
    }
}
