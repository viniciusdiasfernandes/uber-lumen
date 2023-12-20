<?php

namespace Account\Domain;

abstract class Status
{
    public string $value;
    public function __construct(public Account $account)
    {
    }

    public abstract function create(): void;
    public abstract function active(): void;
    public abstract function forget(): void;
}