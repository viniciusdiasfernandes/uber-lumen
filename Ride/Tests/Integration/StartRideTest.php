<?php


use Ride\Application\UseCase\AcceptRide;
use Ride\Application\UseCase\DTO\AcceptRideInput;
use Ride\Application\UseCase\DTO\RequestRideInput;
use Ride\Application\UseCase\DTO\RequestRideOutput;
use Ride\Application\UseCase\DTO\StartRideInput;
use Ride\Application\UseCase\RequestRide;
use Ride\Application\UseCase\StartRide;
use Ride\Domain\StatusEnum;
use Ride\Infra\Gateway\AccountGatewayHttp;
use Ride\Infra\Http\HttpIlluminateClientAdapter;
use Ride\Infra\Repository\RideRepositoryIlluminateDatabase;
use Ride\Tests\TestCase;

class StartRideTest extends TestCase
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
        $inputAcceptRide = new AcceptRideInput(rideId: $ride->rideId, driverId: $driver->accountId);
        $acceptRide = new AcceptRide($rideRepository, $accountGateway);
        $acceptRide->execute($inputAcceptRide);
        $inputStartRide = new StartRideInput(rideId: $ride->rideId, driverId: $driver->accountId);
        $startRide = new StartRide($rideRepository, $accountGateway);
        $output = $startRide->execute($inputStartRide);
        $this->assertEquals(StatusEnum::InProgress, $output->status);
        $this->assertEquals($inputStartRide->rideId, $output->rideId);
    }

    /**
     * @throws Exception
     */
    public function testExecuteDriverAccountDoNotExists()
    {
        $rideRepository = new RideRepositoryIlluminateDatabase();
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $inputStartRide = new StartRideInput(rideId: "", driverId: "SomeDriverId");
        $startRide = new StartRide($rideRepository, $accountGateway);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Trying to start a ride but Driver account do not exists");
        $startRide->execute($inputStartRide);
    }

    public function testExecuteWhenRideNotFound()
    {
        $rideRepository = new RideRepositoryIlluminateDatabase();
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $driver = $this->createDriver();
        $inputStartRide = new StartRideInput(rideId:"SomeRideId", driverId: $driver->accountId);
        $startRide = new StartRide($rideRepository, $accountGateway);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Ride do not exists while trying to start it.");
        $startRide->execute($inputStartRide);
    }

    /**
     * @throws Exception
     */
    public function testExecuteWhenRideIsNotAccepted()
    {
        $rideRepository = new RideRepositoryIlluminateDatabase();
        $httpClient = new HttpIlluminateClientAdapter();
        $accountGateway = new AccountGatewayHttp($httpClient);
        $driver = $this->createDriver();
        $ride = $this->createRide();
        $inputStartRide = new StartRideInput(rideId: $ride->rideId, driverId: $driver->accountId);
        $startRide = new StartRide($rideRepository, $accountGateway);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("You can just start accepted ride");
        $startRide->execute($inputStartRide);
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
        $input = new RequestRideInput($passenger->accountId, "-27.584905257808835", "-48.545022195325124", "-27.496887588317275", "-48.522234807851476");
        return $requestRide->execute($input);
    }
}
