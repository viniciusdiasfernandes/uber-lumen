<?php

namespace Account\Infra\Controller\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SignupRequestValidator
{
    protected static array $rules = [
        "name" => ["required", "string"],
        "email" => ["required", "string", "email"],
        "cpf" => ["required", "string"],
        "password" => ["required", "string"],
        "isPassenger" => ["required", "bool", "different:isDriver"],
        "isDriver" => ["required", "bool", "different:isPassenger"],
        "carPlate" => [ "nullable","string", "required_if:isDriver,true", "required_if:isPassenger,false", "regex:'[A-Z]{3}[0-9][0-9A-Z][0-9]{2}'"]
    ];

    /**
     * @throws ValidationException
     */
    public static function execute(Request $request): void
    {
        $requestData = $request->toArray();
        if(isset($requestData["isPassenger"]) && $requestData["isPassenger"]  && $requestData['carPlate']) {
            unset($requestData["carPlate"]);
            unset(self::$rules["carPlate"]);
        }
        Validator::make( $request->toArray(), self::$rules)->validate();
    }
}
