<?php

namespace Ride\Domain;

abstract class Status
{
    public string $value;
    public function __construct(public Ride $ride)
    {
    }

    public abstract function request(): void;
    public abstract function accept(): void;
    public abstract function start(): void;
    public abstract function finish(): void;
    public abstract function cancel(): void;
}
