<?php

namespace Ride\Application\UseCase;

use Exception;
use Ride\Application\Gateway\AccountGateway;
use Ride\Application\Repository\RideRepository;
use Ride\Application\UseCase\DTO\RequestRideInput;
use Ride\Application\UseCase\DTO\RequestRideOutput;
use Ride\Domain\Ride;
use Symfony\Component\HttpFoundation\Response;

class RequestRide
{
    public function __construct(readonly RideRepository $rideRepository, readonly AccountGateway $accountGateway)
    {
    }

    /**
     * @throws Exception
     */
    public function execute(RequestRideInput $input): RequestRideOutput
    {
        $response = $this->accountGateway->getById($input->passengerId);
        $responseData = json_decode($response);
        if(!$responseData->success) throw new Exception("Trying to request a ride but Passenger account do not exists", Response::HTTP_UNPROCESSABLE_ENTITY);
        $passengerHasANonConcludedRides = $this->rideRepository->getActiveRidesByPassengerId($input->passengerId);
        if($passengerHasANonConcludedRides) throw new Exception("Passenger has an active ride", Response::HTTP_UNPROCESSABLE_ENTITY);
        $ride = Ride::create(
            $input->passengerId,
            0,
            0,
            $input->fromLat,
            $input->fromLong,
            $input->toLong,
            $input->toLat
        );
        $this->rideRepository->save($ride);
        return new RequestRideOutput($ride->rideId);
    }
}
