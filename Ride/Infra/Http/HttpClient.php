<?php

namespace Ride\Infra\Http;

interface HttpClient
{
    public function get(string $url);
    public function post(string $url, array $data);
    public function put(string $url, array $data);
}
