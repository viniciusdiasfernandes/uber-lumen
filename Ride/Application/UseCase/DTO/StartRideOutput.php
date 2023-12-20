<?php

namespace Ride\Application\UseCase\DTO;

class StartRideOutput
{
    public function __construct(
        readonly string $rideId,
        readonly string $status
    )
    {
    }
}
