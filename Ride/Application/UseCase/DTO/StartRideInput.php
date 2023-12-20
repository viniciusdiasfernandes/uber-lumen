<?php

namespace Ride\Application\UseCase\DTO;

class StartRideInput
{
    public function __construct(
        readonly string $rideId,
        readonly string $driverId
    )
    {
    }
}
