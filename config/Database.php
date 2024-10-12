<?php

namespace Config;

use mysqli;

class Database
{
    private $connection;
    private $host = 'localhost';
    private $user = 'effism';
    private $password = 'admin';
    private $database = 'cms';

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
