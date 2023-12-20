<?php

namespace Ride\Tests\Integration;

use Exception;
use Ride\Application\UseCase\DTO\RequestRideInput;
use Ride\Application\UseCase\RequestRide;
use Ride\Infra\Gateway\AccountGatewayHttp;
use Ride\Infra\Http\HttpIlluminateClientAdapter;
use Ride\Infra\Repository\RideRepositoryIlluminateDatabase;
use Ride\Tests\TestCase;

class RequestRideTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testExecute()
    {
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $response = $accountGateway->signup([
            "name" => "Vinicius",
            "email" => "vinidiax".uniqid()."@gmail.com",
            "cpf" =>"565.486.780-60",
            "password" => "test123",
            "isPassenger" => true,
            "isDriver" => false,
            "carPlate" => ""
        ]);
        $responseData = json_decode($response);
        $rideRepository = new RideRepositoryIlluminateDatabase();
        $input = new RequestRideInput($responseData->accountId,"-27.584905257808835","-48.545022195325124", "-27.496887588317275", "-48.522234807851476");
        $requestRide = new RequestRide($rideRepository, $accountGateway);
        $rideId = $requestRide->execute($input);
        $this->assertNotNull($rideId);
    }

    public function testExecuteWhenAccountDoNotExists()
    {
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $rideRepository = new RideRepositoryIlluminateDatabase();
        $input = new RequestRideInput("test123456789DONOTEXISTS","-27.584905257808835","-48.545022195325124", "-27.496887588317275", "-48.522234807851476");
        $requestRide = new RequestRide($rideRepository, $accountGateway);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Trying to request a ride but Passenger account do not exists");
        $requestRide->execute($input);
    }

    /**
     * @throws Exception
     */
    public function testExecuteWhenPassengerHasANonConcludedRide(): void
    {
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $response = $accountGateway->signup([
            "name" => "Vinicius",
            "email" => "vinidiax".uniqid()."@gmail.com",
            "cpf" =>"565.486.780-60",
            "password" => "test123",
            "isPassenger" => true,
            "isDriver" => false,
            "carPlate" => ""
        ]);
        $responseData = json_decode($response);
        $rideRepository = new RideRepositoryIlluminateDatabase();
        $input = new RequestRideInput($responseData->accountId,"-27.584905257808835","-48.545022195325124", "-27.496887588317275", "-48.522234807851476");
        $requestRide = new RequestRide($rideRepository, $accountGateway);
        $requestRide->execute($input);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Passenger has an active ride");
        $requestRide->execute($input);
    }
}
