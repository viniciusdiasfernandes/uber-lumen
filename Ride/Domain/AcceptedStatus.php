<?php

namespace Ride\Domain;

use Exception;

class AcceptedStatus extends Status
{
    public string $value;
    public function __construct(Ride $ride)
    {
        parent::__construct($ride);
        $this->value = StatusEnum::Accepted;
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
        $this->ride->status = new InProgressStatus($this->ride);
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
