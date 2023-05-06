<?php
namespace App\Util;

// database class to connect to the database
class Database
{

    // database connection properties
    private $connection;

    public function __construct()
    {

        // database connection properties stored in variables
        $dsn = 'mysql:host=localhost;dbname=task1;charset=utf8mb4';
        $user = 'root';
        $password = '';

        // try to connect to the database
        try {
            $this->connection = new \PDO($dsn, $user, $password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        // if connection fails throw an exception and display the error message
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // function to return the database connection
    public function getConnection()
    {
        return $this->connection;
    }
}