<?php

namespace Account\Domain;

class HashPassword implements Password
{

    private  string $algorithm;

    private function __construct(public string $value, readonly string $salt)
    {
        $this->algorithm = PASSWORD_DEFAULT;
    }

    public static function create(string $password): HashPassword
    {
        $value = password_hash($password, PASSWORD_DEFAULT);
        return new HashPassword($value, "");
    }

    public static function restore(string $password, string $salt = ""): HashPassword
    {
		return new HashPassword($password, $salt);
	}

    public function validate(string $password): bool
    {
        return (password_verify($password, $this->value));
    }

    public function getValue(): string
    {
        return $this->value;
    }
}