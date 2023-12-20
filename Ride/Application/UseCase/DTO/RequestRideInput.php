<?php

namespace Ride\Application\UseCase\DTO;

class RequestRideInput
{
    public function __construct(
        readonly string $passengerId,
        readonly string  $fromLat,
        readonly string  $fromLong,
        readonly string  $toLat,
        readonly string  $toLong,
    )
    {
    }
}
