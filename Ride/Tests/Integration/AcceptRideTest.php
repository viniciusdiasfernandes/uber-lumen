<?php

namespace Ride\Tests\Integration;

use Exception;
use Ride\Application\UseCase\AcceptRide;
use Ride\Application\UseCase\DTO\AcceptRideInput;
use Ride\Application\UseCase\DTO\RequestRideInput;
use Ride\Application\UseCase\DTO\RequestRideOutput;
use Ride\Application\UseCase\RequestRide;
use Ride\Domain\StatusEnum;
use Ride\Infra\Gateway\AccountGatewayHttp;
use Ride\Infra\Http\HttpIlluminateClientAdapter;
use Ride\Infra\Repository\RideRepositoryIlluminateDatabase;
use Ride\Tests\TestCase;
use stdClass;

class AcceptRideTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testExecuteOnSuccess()
    {
        $rideRepository = new RideRepositoryIlluminateDatabase();
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $driver = $this->createDriver();
        $ride = $this->createRide();
        $input = new AcceptRideInput(rideId: $ride->rideId, driverId: $driver->accountId);
        $acceptRide = new AcceptRide($rideRepository, $accountGateway);
        $output = $acceptRide->execute($input);
        $this->assertEquals(StatusEnum::Accepted, $output->status);
        $this->assertEquals($input->rideId, $output->rideId);
    }


    public function testExecuteWhenDriverHasAnActiveRide()
    {
        $rideRepository = new RideRepositoryIlluminateDatabase();
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $input = new AcceptRideInput(rideId: "SomeRideId", driverId: "SomeDriverId");
        $acceptRide = new AcceptRide($rideRepository, $accountGateway);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Trying to accept a ride but Driver account do not exists");
        $acceptRide->execute($input);

    }

    /**
     * @throws Exception
     */
    public function testExecuteWheRideIsAlreadyActive()
    {
        $rideRepository = new RideRepositoryIlluminateDatabase();
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $driver = $this->createDriver();
        $ride = $this->createRide();
        $input = new AcceptRideInput(rideId: $ride->rideId, driverId: $driver->accountId);
        $acceptRide = new AcceptRide($rideRepository, $accountGateway);
        $acceptRide->execute($input);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Ride can not be accepted while another is active");
        $acceptRide->execute($input);
    }

    public function testExecuteWhenRideNotFound()
    {
        $rideRepository = new RideRepositoryIlluminateDatabase();
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $driver = $this->createDriver();
        $input = new AcceptRideInput(rideId: "SomeRideId", driverId: $driver->accountId);
        $acceptRide = new AcceptRide($rideRepository, $accountGateway);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Ride do not exists while trying to accept it.");
        $acceptRide->execute($input);
    }

    /**
     * @throws Exception
     */
    public function testExecuteWhenRideIsNotRequested()
    {
        $rideRepository = new RideRepositoryIlluminateDatabase();
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $driver = $this->createDriver();
        $ride = $this->createRide();
        $ride = $rideRepository->getById($ride->rideId);
        $ride->cancel();
        $rideRepository->update($ride);
        $input = new AcceptRideInput(rideId: $ride->rideId, driverId: $driver->accountId);
        $acceptRide = new AcceptRide($rideRepository, $accountGateway);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("You can just accept requested ride");
        $acceptRide->execute($input);
    }

    private function createPassenger()
    {
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $response = $accountGateway->signup([
            "name" => "Vinicius",
            "email" => "vinidiax" . uniqid() . "@gmail.com",
            "cpf" => "565.486.780-60",
            "password" => "test123",
            "isPassenger" => true,
            "isDriver" => false,
            "carPlate" => ""
        ]);
        return json_decode($response);
    }

    private function createDriver(): stdClass
    {
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $response = $accountGateway->signup([
            "name" => "Vinicius",
            "email" => "vinidiax" . uniqid() . "@gmail.com",
            "cpf" => "565.486.780-60",
            "password" => "test123",
            "isPassenger" => false,
            "isDriver" => true,
            "carPlate" => "AAA0101"
        ]);
        return json_decode($response);
    }

    /**
     * @throws Exception
     */
    public function createRide(): RequestRideOutput
    {
        $passenger = $this->createPassenger();
        $rideRepository = new RideRepositoryIlluminateDatabase();
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $requestRide = new RequestRide($rideRepository, $accountGateway);
        $input = new RequestRideInput($passenger->accountId, -27.584905257808835, -48.545022195325124, -27.496887588317275, -48.522234807851476);
        return $requestRide->execute($input);
    }
}
