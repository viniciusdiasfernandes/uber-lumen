<?php

namespace Ride\Application\UseCase\DTO;

class AcceptRideInput
{
    public function __construct(
        readonly string $rideId,
        readonly string $driverId
    )
    {
    }
}
