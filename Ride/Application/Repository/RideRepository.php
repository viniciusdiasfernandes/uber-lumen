<?php

namespace Ride\Application\Repository;

use Ride\Domain\Ride;

interface RideRepository
{
    public function save(Ride $ride): void;

    /** @return Ride [] */
    public function getActiveRidesByPassengerId(string $passengerId): array;

    public function getById(string $rideId): Ride|null;

    /** @return Ride [] */
    public function getActiveRidesByDriverId(string $driverId): array;

    public function update(Ride $ride);
}
