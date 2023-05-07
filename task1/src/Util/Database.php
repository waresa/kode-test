<?php

namespace App\Util;

// Database class for connecting to the database
class Database
{
    // Database connection property
    private $connection;

    // Constructor for initializing the database connection
    public function __construct()
    {
        // Database connection properties stored in variables
        $dsn = 'mysql:host=127.0.0.1;dbname=task1;charset=utf8mb4';
        $user = 'root';
        $password = '';

        // Try to connect to the database
        try {
            $this->connection = new \PDO($dsn, $user, $password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            // If connection fails, throw an exception and display the error message
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // Function to return the database connection
    public function getConnection()
    {
        return $this->connection;
    }
}