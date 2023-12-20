<?php

namespace Ride\Tests\Unit;

use Exception;
use Ride\Domain\AcceptedStatus;
use Ride\Domain\CancelledStatus;
use Ride\Domain\CompletedStatus;
use Ride\Domain\InProgressStatus;
use Ride\Domain\RequestedStatus;
use Ride\Domain\Ride;
use Ride\Domain\StatusEnum;
use Ride\Domain\StatusFactory;
use Ride\Tests\TestCase;

class StatusFactoryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreateAcceptedStatus()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = StatusFactory::create($ride, StatusEnum::Accepted);
        $this->assertInstanceOf(AcceptedStatus::class, $status);
    }

    /**
     * @throws Exception
     */
    public function testCreateCancelledStatus()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = StatusFactory::create($ride, StatusEnum::Cancelled);
        $this->assertInstanceOf(CancelledStatus::class, $status);
    }

    /**
     * @throws Exception
     */
    public function testCreateCompletedStatus()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = StatusFactory::create($ride, StatusEnum::Completed);
        $this->assertInstanceOf(CompletedStatus::class, $status);
    }

    /**
     * @throws Exception
     */
    public function testCreateInProgressStatus()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = StatusFactory::create($ride, StatusEnum::InProgress);
        $this->assertInstanceOf(InProgressStatus::class, $status);
    }

    /**
     * @throws Exception
     */
    public function testCreateRequestedStatus()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = StatusFactory::create($ride, StatusEnum::Requested);
        $this->assertInstanceOf(RequestedStatus::class, $status);
    }

    /**
     * @throws Exception
     */
    public function testCreateWhenStatusDoNotExists()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $this->expectException(Exception::class);
        $status = StatusFactory::create($ride, "SOME-STATUS");
    }
}
