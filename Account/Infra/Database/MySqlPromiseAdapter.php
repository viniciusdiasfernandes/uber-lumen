<?php

namespace Account\Infra\Database;

use mysqli;
use mysqli_result;

class MySqlPromiseAdapter implements Connection
{
    private mysqli $connection;
    public function __construct()
    {
        $this->connection = new mysqli();
        $this->connection->connect("host.docker.internal","root","test123","uber");
    }

    public function query(string $statement): mysqli_result|bool
    {
        return $this->connection->query($statement);
    }

    public function close(): void
    {
        $this->connection->close();
    }
}