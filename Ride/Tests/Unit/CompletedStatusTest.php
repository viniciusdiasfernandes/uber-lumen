<?php

use Ride\Domain\CompletedStatus;
use Ride\Domain\Ride;
use Ride\Tests\TestCase;

class CompletedStatusTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testRequest()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new CompletedStatus($ride);
        $this->expectException(Exception::class);
        $status->request();
    }

    /**
     * @throws Exception
     */
    public function testAccept()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new CompletedStatus($ride);
        $this->expectException(Exception::class);
        $status->accept();
    }

    /**
     * @throws Exception
     */
    public function testStart()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new CompletedStatus($ride);
        $this->expectException(Exception::class);
        $status->start();
    }

    /**
     * @throws Exception
     */
    public function testFinish()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new CompletedStatus($ride);
        $this->expectException(Exception::class);
        $status->finish();
    }

    /**
     * @throws Exception
     */
    public function testCancel()
    {
        $ride = Ride::create(1,0,0,123,123,123,123);
        $status = new CompletedStatus($ride);
        $this->expectException(Exception::class);
        $status->cancel();
    }
}
