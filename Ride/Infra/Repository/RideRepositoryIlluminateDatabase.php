<?php

namespace Ride\Infra\Repository;

use Exception;
use Illuminate\Support\Facades\DB;
use Ride\Application\Repository\RideRepository;
use Ride\Domain\Ride;
use Ride\Domain\StatusEnum;

class RideRepositoryIlluminateDatabase implements RideRepository
{

    public function save(Ride $ride): void
    {

        DB::table("ride")->insert([
            "ride_id" => $ride->rideId,
            "passenger_id" => $ride->passengerId,
            "status" => $ride->status->value,
            "fare" => $ride->fare,
            "distance" => $ride->distance,
            "from_lat" => $ride->fromLat,
            "from_long" => $ride->fromLong,
            "to_lat" => $ride->toLat,
            "to_long" => $ride->toLong,
            "date" => $ride->date
        ]);
    }

    /**
     * @param string $passengerId
     * @return Ride []
     * @throws Exception
     */
    public function getActiveRidesByPassengerId(string $passengerId): array
    {
        $ridesCollection = DB::table("ride")
            ->select()
            ->where("passenger_id", "=", $passengerId)
            ->whereNotIn("status", [StatusEnum::Cancelled, StatusEnum::Completed])
            ->get();
        $rides = [];
        foreach ($ridesCollection as $ride) {
            $rides[] = Ride::restore($ride->ride_id, $ride->passenger_id, $ride->status, $ride->fare, $ride->distance, $ride->from_lat, $ride->from_long, $ride->to_lat, $ride->to_long, $ride->date, $ride->driver_id);
        }
        return $rides;
    }

    /**
     * @throws Exception
     */
    public function getById(string $rideId): Ride|null
    {
        $ride = DB::table("ride")
            ->select()
            ->where("ride_id", "=", $rideId)
            ->first();
        if (!$ride) return null;
        return Ride::restore($ride->ride_id, $ride->passenger_id, $ride->status, $ride->fare, $ride->distance, $ride->from_lat, $ride->from_long, $ride->to_lat, $ride->to_long, $ride->date, $ride->driver_id);
    }

    /** @return Ride[]
     * @throws Exception
     */
    public function getActiveRidesByDriverId(string $driverId): array
    {
        $ridesCollection = DB::table("ride")
            ->select()
            ->where("driver_id","=", $driverId)
            ->whereIn("status", [StatusEnum::InProgress, StatusEnum::Accepted])
            ->get();
        $rides = [];
        foreach ($ridesCollection as $ride) {
            $rides[] = Ride::restore($ride->ride_id, $ride->passenger_id, $ride->status, $ride->fare, $ride->distance, $ride->from_lat, $ride->from_long, $ride->to_lat, $ride->to_long, $ride->date, $ride->driver_id);
        }
        return $rides;
    }

    public function update(Ride $ride): void
    {
        DB::table("ride")->where("ride_id","=", $ride->rideId)->update([
            "driver_id" => $ride->getDriverId(),
            "status" => $ride->status->value,
            "fare" => $ride->fare,
            "distance" => $ride->distance,
            "from_lat" => $ride->fromLat,
            "from_long" => $ride->fromLong,
            "to_lat" => $ride->toLat,
            "to_long" => $ride->toLong
        ]);
    }
}
