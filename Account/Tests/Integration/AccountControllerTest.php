<?php

namespace Account\Tests\Integration;

use Account\Infra\Controller\AccountController;
use Account\Tests\TestCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class AccountControllerTest extends TestCase
{
    public function testRoutesAreWorking()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, "http://host.docker.internal:81/signup");
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type:application/json"
        ]);
        $output = curl_exec($curl);
        curl_close($curl);
        $this->assertTrue($output);
        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_P, 1);
        curl_setopt($curl, CURLOPT_URL, "http://host.docker.internal:81/account/1");
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type:application/json"
        ]);
        $output = curl_exec($curl);
        $this->assertTrue($output);
    }

    public function testSignup()
    {
        $parameters = [
            "name" => "Vinicius Dias Fernandes",
            "email" => "vini" . rand(1000, 9999) . "@gmail.com",
            "cpf" => "565.486.780-60",
            "password" => "test123",
            "isPassenger" => true,
            "isDriver" => false,
            "carPlate" => null
        ];
        $request = Request::create(
            uri: "http://host.docker.internal:81/signup",
            method: "POST",
            parameters: $parameters
        );
        $accountController = new AccountController();
        $response = $accountController->signup($request);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testSignupValidationError()
    {
        $parameters = [
            "name" => "",
            "email" => "vini" . rand(1000, 9999) . "@gmail.com",
            "cpf" => "565.486.780-60",
            "password" => "test123",
            "isPassenger" => true,
            "isDriver" => false,
            "carPlate" => null
        ];
        $request = Request::create(
            uri: "http://host.docker.internal:81/signup",
            method: "POST",
            parameters: $parameters
        );
        $accountController = new AccountController();
        $output = $accountController->signup($request);
        $this->assertInstanceOf(JsonResponse::class, $output);
    }

    public function testGetById()
    {
        $parameters = [
            "name" => "Vinicius Dias Fernandes",
            "email" => "vini" . rand(1000, 9999) . "@gmail.com",
            "cpf" => "565.486.780-60",
            "password" => "test123",
            "isPassenger" => true,
            "isDriver" => false,
            "carPlate" => null
        ];
        $request = Request::create(
            uri: "http://host.docker.internal:81/signup",
            method: "POST",
            parameters: $parameters
        );
        $accountController = new AccountController();
        $responseSignup = $accountController->signup($request);
        $responseSignupData = json_decode($responseSignup->getContent());
        $responseGetAccount = $accountController->getById($responseSignupData->accountId);
        $responseGetAccountData = json_decode($responseGetAccount->getContent());
        $this->assertEquals($responseSignupData->accountId, $responseGetAccountData->accountId);
    }

    public function testGetByIdWhenItDoNotExists()
    {
       $accountController = new AccountController();
        $response = $accountController->getById("test123456789DONOTEXISTS");
        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = json_decode($response->getContent());
        $this->assertEquals("Account do not exists", $responseData);
    }
}
