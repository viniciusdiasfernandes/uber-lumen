<?php

namespace Account\Infra\Database;

interface Connection
{
    public function query(string $statement);
    public function close(): void;
}