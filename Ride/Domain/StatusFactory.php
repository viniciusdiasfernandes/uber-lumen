<?php

namespace Ride\Domain;


use Exception;

class StatusFactory
{
    /**
     * @throws Exception
     */
    public static function create(Ride $ride, string $status): Status
    {
        if($status === StatusEnum::Requested) return new RequestedStatus($ride);
        if($status === StatusEnum::Accepted) return new AcceptedStatus($ride);
        if($status === StatusEnum::InProgress) return new InProgressStatus($ride);
        if($status === StatusEnum::Completed) return new CompletedStatus($ride);
        if($status === StatusEnum::Cancelled) return new CancelledStatus($ride);
        throw new Exception("Invalid status");
    }
}
