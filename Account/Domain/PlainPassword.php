<?php

namespace Account\Domain;

class PlainPassword implements Password
{

    private function __construct(public string $value, readonly string $salt)
    {
    }

    public static function create(string $password): PlainPassword
    {
        return new PlainPassword($password, "");
    }

    public static function restore(string $password, string $salt): PlainPassword
    {
        return new PlainPassword($password, $salt);
    }

    public function validate(string $password): bool
    {
        return $this->value === $password;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}