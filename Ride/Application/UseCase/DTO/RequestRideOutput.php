<?php

namespace Ride\Application\UseCase\DTO;

class RequestRideOutput
{
    public function __construct(
        readonly string $rideId
    )
    {
    }
}
