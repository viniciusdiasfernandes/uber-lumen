<?php

namespace Ride\Tests\Unit;

use Exception;
use Ride\Domain\AcceptedStatus;
use Ride\Domain\Ride;
use Ride\Domain\StatusEnum;
use Ride\Tests\TestCase;

class AcceptedStatusTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testRequest()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new AcceptedStatus($ride);
        $this->expectException(Exception::class);
        $status->request();
    }

    /**
     * @throws Exception
     */
    public function testAccept()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new AcceptedStatus($ride);
        $this->expectException(Exception::class);
        $status->accept();
    }

    /**
     * @throws Exception
     */
    public function testStart()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new AcceptedStatus($ride);
        $status->start();
        $this->assertEquals(StatusEnum::InProgress, $status->ride->status->value);
    }

    /**
     * @throws Exception
     */
    public function testFinish()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new AcceptedStatus($ride);
        $this->expectException(Exception::class);
        $status->finish();
    }

    /**
     * @throws Exception
     */
    public function testCancel()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new AcceptedStatus($ride);
        $status->cancel();
        $this->assertEquals(StatusEnum::Cancelled, $status->ride->status->value);
    }
}
