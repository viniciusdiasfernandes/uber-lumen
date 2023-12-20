<?php

namespace Ride\Tests\Unit;

use Exception;
use Ride\Domain\Ride;
use Ride\Domain\StatusEnum;
use Ride\Tests\TestCase;

class RideTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreate()
    {
        $ride = Ride::create("test", 0, 0, 123, 123, 123, 123);
        $this->assertNotNull($ride->rideId);
        $this->assertEquals("test", $ride->passengerId);
        $this->assertEquals(StatusEnum::Requested, $ride->status->value);
        $this->assertEquals(0, $ride->fare);
        $this->assertEquals(0, $ride->distance);
        $this->assertEquals(123, $ride->fromLat);
        $this->assertEquals(123, $ride->fromLong);
        $this->assertEquals(123, $ride->toLat);
        $this->assertEquals(123, $ride->toLong);
        $this->assertNotNull($ride->date);

    }

    /**
     * @throws Exception
     */
    public function testRestore()
    {
        $ride = Ride::restore("test", "test", StatusEnum::Requested, 0, 0, 123, 123, 123, 123, 123, "test");
        $this->assertEquals("test", $ride->rideId);
        $this->assertEquals("test", $ride->passengerId);
        $this->assertEquals(StatusEnum::Requested, $ride->status->value);
        $this->assertEquals(0, $ride->fare);
        $this->assertEquals(0, $ride->distance);
        $this->assertEquals(123, $ride->fromLat);
        $this->assertEquals(123, $ride->fromLong);
        $this->assertEquals(123, $ride->toLat);
        $this->assertEquals(123, $ride->toLong);
        $this->assertNotNull($ride->date);
        $this->assertEquals("test", $ride->getDriverId());
    }
}
