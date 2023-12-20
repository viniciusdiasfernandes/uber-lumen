<?php

namespace Account\Domain;

interface Password
{
    public static function create(string $password): Password;

    public static function restore(string $password, string $salt): Password;

    public function validate(string $password): bool;

    public function getValue(): string;
}