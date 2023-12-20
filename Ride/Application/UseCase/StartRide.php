<?php

namespace Ride\Application\UseCase;

use Exception;
use Ride\Application\Gateway\AccountGateway;
use Ride\Application\Repository\RideRepository;
use Ride\Application\UseCase\DTO\StartRideInput;
use Ride\Application\UseCase\DTO\StartRideOutput;
use Ride\Domain\StatusEnum;
use Symfony\Component\HttpFoundation\Response;

class StartRide
{
    public function __construct(readonly RideRepository $rideRepository, readonly AccountGateway $accountGateway)
    {
    }

    /**
     * @throws Exception
     */
    public function execute(StartRideInput $input): StartRideOutput
    {
        $response = $this->accountGateway->getById($input->driverId);
        $responseData = json_decode($response);
        if (!$responseData->success) throw new Exception("Trying to start a ride but Driver account do not exists", Response::HTTP_UNPROCESSABLE_ENTITY);
        $ride = $this->rideRepository->getById($input->rideId);
        if (!$ride) throw new Exception("Ride do not exists while trying to start it.", Response::HTTP_UNPROCESSABLE_ENTITY);
        if ($ride->status->value !== StatusEnum::Accepted) throw new Exception("You can just start accepted ride", Response::HTTP_UNPROCESSABLE_ENTITY);
        $ride->start();
        $this->rideRepository->update($ride);
        return new StartRideOutput($ride->rideId, $ride->status->value);
    }
}
