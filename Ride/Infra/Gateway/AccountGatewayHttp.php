<?php

namespace Ride\Infra\Gateway;

use Ride\Infra\Http\HttpClient;
use Ride\Application\Gateway\AccountGateway;

class AccountGatewayHttp implements AccountGateway
{
    public function __construct(readonly HttpClient $httpClient)
    {
    }

    public function getById(string $accountId): string
    {
        return $this->httpClient->get("http://host.docker.internal:81/account/{$accountId}");
    }

    public function signup(array $data): string
    {
        return $this->httpClient->post("http://host.docker.internal:81/signup", $data);
    }
}
