<?php

namespace Ride\Application\UseCase;

use Exception;
use Ride\Application\Gateway\AccountGateway;
use Ride\Application\Repository\RideRepository;
use Ride\Application\UseCase\DTO\AcceptRideInput;
use Ride\Application\UseCase\DTO\AcceptRideOutput;
use Ride\Application\UseCase\DTO\RequestRideInput;
use Ride\Application\UseCase\DTO\RequestRideOutput;
use Ride\Domain\Ride;
use Ride\Domain\StatusEnum;
use Symfony\Component\HttpFoundation\Response;

class AcceptRide
{
    public function __construct(readonly RideRepository $rideRepository, readonly AccountGateway $accountGateway)
    {
    }

    /**
     * @throws Exception
     */
    public function execute(AcceptRideInput $input): AcceptRideOutput
    {
        $response = $this->accountGateway->getById($input->driverId);
        $responseData = json_decode($response);
        if(!$responseData->success) throw new Exception("Trying to accept a ride but Driver account do not exists", Response::HTTP_UNPROCESSABLE_ENTITY);
        $driverHasActiveRide = $this->rideRepository->getActiveRidesByDriverId($input->driverId);
        if($driverHasActiveRide) throw new Exception("Ride can not be accepted while another is active");
        $ride = $this->rideRepository->getById($input->rideId);
        if(!$ride) throw new Exception("Ride do not exists while trying to accept it.", Response::HTTP_UNPROCESSABLE_ENTITY);
        if($ride->status->value !== StatusEnum::Requested) throw new Exception("You can just accept requested ride");
        $ride->accept($input->driverId);
        $this->rideRepository->update($ride);
        return new AcceptRideOutput($ride->rideId, $ride->status->value);
    }
}
