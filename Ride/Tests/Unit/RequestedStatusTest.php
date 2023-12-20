<?php

use Ride\Domain\RequestedStatus;
use Ride\Domain\Ride;
use Ride\Domain\StatusEnum;
use Ride\Tests\TestCase;

class RequestedStatusTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testRequest()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new RequestedStatus($ride);
        $this->expectException(Exception::class);
        $status->request();
    }

    /**
     * @throws Exception
     */
    public function testAccept()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new RequestedStatus($ride);
        $status->accept();
        $this->assertEquals(StatusEnum::Accepted, $status->ride->status->value);
    }

    /**
     * @throws Exception
     */
    public function testStart()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new RequestedStatus($ride);
        $this->expectException(Exception::class);
        $status->start();
    }

    /**
     * @throws Exception
     */
    public function testFinish()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new RequestedStatus($ride);
        $this->expectException(Exception::class);
        $status->finish();
    }

    /**
     * @throws Exception
     */
    public function testCancel()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new RequestedStatus($ride);
        $status->cancel();
        $this->assertEquals(StatusEnum::Cancelled, $status->ride->status->value);
    }
}
