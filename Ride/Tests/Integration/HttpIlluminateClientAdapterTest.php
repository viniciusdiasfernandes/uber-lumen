<?php

namespace Ride\Tests\Integration;

use Ride\Infra\Http\HttpIlluminateClientAdapter;
use Ride\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class HttpIlluminateClientAdapterTest extends TestCase
{
    public function testGet()
    {
        $httpClient = new HttpIlluminateClientAdapter();
        $response = $httpClient->get("http://host.docker.internal:81/account/999999999999");
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->status());
    }

    public function testPost()
    {
        $httpClient = new HttpIlluminateClientAdapter();
        $response = $httpClient->post("http://host.docker.internal:81/signup",[]);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->status());
    }

    public function testPut()
    {
        $httpClient = new HttpIlluminateClientAdapter();
        $response = $httpClient->put("http://host.docker.internal:81/account/99999999999",[]);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->status());
    }
}
