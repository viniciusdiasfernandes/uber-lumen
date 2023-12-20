<?php

namespace Ride\Domain;

use Exception;
use Illuminate\Support\Facades\Date;
use Ramsey\Uuid\Uuid;

class Ride
{
    public Status $status;
    private ?string $driverId;

    /**
     * @throws Exception
     */
    private function __construct(
        readonly string  $rideId,
        readonly string  $passengerId,
        string  $status,
        readonly float  $fare,
        readonly float  $distance,
        readonly string  $fromLat,
        readonly string  $fromLong,
        readonly string  $toLat,
        readonly string  $toLong,
        readonly int     $date
    )
    {
        $this->status = StatusFactory::create($this, $status);
    }

    /**
     * @throws Exception
     */
    public static function create(string $passengerId, float $fare, float $distance, string $fromLat, string $fromLong, string $toLat, string $toLong): Ride
    {
        $rideId = Uuid::uuid4();
        $date = Date::now()->timestamp;
        $status = StatusEnum::Requested;
        return new Ride($rideId, $passengerId, $status, $fare, $distance, $fromLat, $fromLong, $toLat, $toLong, $date);
    }

    /**
     * @throws Exception
     */
    public static function restore(string $rideId, string $passengerId, string $status, float $fare, float $distance, string $fromLat, string $fromLong, string $toLat, string $toLong, int $date, string $driverId = null): Ride
    {
        $ride =  new Ride($rideId, $passengerId, $status, $fare, $distance, $fromLat, $fromLong, $toLat, $toLong, $date);
        $ride->driverId = $driverId;
        return $ride;
    }

    /**
     * @throws Exception
     */
    public function accept(string $driverId): void
    {
        $this->driverId = $driverId;
        $this->status->accept();
    }
    public function getDriverId(): ?string
    {
        return $this->driverId;
    }

    public function cancel(): void
    {
        $this->status->cancel();
    }

    public function start(): void
    {
        $this->status->start();
    }
}
