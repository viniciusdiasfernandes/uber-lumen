<?php

namespace Account\Infra\Queue;

interface Queue
{
    public function publish(string $queueName, array $input): void;
    public function consume(string $queueName, callable $callback): void;
}