<?php

namespace Account\Domain;

use Exception;

class PasswordFactory
{
    /**
     * @throws Exception
     */
    public static function create(string $algorithm, string $password): Password
    {
        if($algorithm === "plain") return PlainPassword::create($password,"");
        if($algorithm === "hash") return HashPassword::create($password, "");
        throw new Exception("Password algorithm do not exists");
    }
}