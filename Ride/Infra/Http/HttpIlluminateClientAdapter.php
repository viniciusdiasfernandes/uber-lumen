<?php

namespace Ride\Infra\Http;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class HttpIlluminateClientAdapter implements HttpClient
{

    public function get(string $url): Response
    {
        return Http::get($url);
    }

    public function post(string $url, array $data): Response
    {
        return Http::post($url, $data);
    }

    public function put(string $url, array $data): Response
    {
        return Http::put($url, $data);
    }
}
