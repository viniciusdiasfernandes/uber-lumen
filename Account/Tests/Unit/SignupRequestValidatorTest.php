<?php

namespace Account\Tests\Unit;

use Account\Infra\Controller\Validator\SignupRequestValidator;
use Account\Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SignupRequestValidatorTest extends TestCase
{
    private array $parameters;

    public function setUp(): void
    {
        parent::setUp();
        $this->parameters = [
            "name" => "Vinicius Dias Fernandes",
            "email" => "vini" . rand(1000, 9999) . "@gmail.com",
            "cpf" => "565.486.780-60",
            "password" => "test123",
            "isPassenger" => true,
            "isDriver" => false,
            "carPlate" => "AAA0102"
        ];
    }

    /**
     * @throws ValidationException
     */
    public function testExecuteOnSuccess()
    {
        SignupRequestValidator::execute($this->createRequest($this->parameters));
        $this->assertTrue(true);
    }

    public function testEmptyName()
    {
        $parameters = $this->parameters;
        unset($parameters["name"]);
        $this->expectException(ValidationException::class);
        SignupRequestValidator::execute($this->createRequest($parameters));
    }

    public function testEmptyEmail()
    {
        $parameters = $this->parameters;
        unset($parameters["email"]);
        $this->expectException(ValidationException::class);
        SignupRequestValidator::execute($this->createRequest($parameters));
    }

    public function testEmptyPassword()
    {
        $parameters = $this->parameters;
        unset($parameters["password"]);
        $this->expectException(ValidationException::class);
        SignupRequestValidator::execute($this->createRequest($parameters));
    }

    public function testEmptyIsPassenger()
    {
        $parameters = $this->parameters;
        unset($parameters["isPassenger"]);
        $this->expectException(ValidationException::class);
        SignupRequestValidator::execute($this->createRequest($parameters));
    }

    public function testEmptyIsDriver()
    {
        $parameters = $this->parameters;
        unset($parameters["isDriver"]);
        $this->expectException(ValidationException::class);
        SignupRequestValidator::execute($this->createRequest($parameters));
    }

    private function createRequest(array $parameters): Request
    {
        return Request::create(
            uri: "",
            method: "POST",
            parameters: $parameters
        );
    }
}
