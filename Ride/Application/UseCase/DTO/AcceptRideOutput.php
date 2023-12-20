<?php

namespace Ride\Application\UseCase\DTO;

class AcceptRideOutput
{
    public function __construct(
        readonly string $rideId,
        readonly string $status
    )
    {
    }
}
