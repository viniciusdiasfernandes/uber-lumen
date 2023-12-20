<?php

namespace Ride\Tests\Unit;

use Exception;
use Ride\Domain\Coordinate;
use Ride\Tests\TestCase;

class CoordinateTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testConstructor()
    {
        $coordinate = new Coordinate("-27.584905257808835","-48.545022195325124");
        $this->assertNotNull($coordinate->getLatitude());
        $this->assertNotNull($coordinate->getLongitude());
    }

    public function testWhenLatitudeIsInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Invalid latitude");
        new Coordinate(100,27);
    }

    public function testWhenLongitudeIsInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Invalid longitude");
        new Coordinate(27,190);
    }
}
