<?php

namespace core\application;

use PDO;

class Database
{
    private PDO $connection;
    private static $instance = null;

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function __construct()
    {
        DotEnver::getDotEnv();
        $dbHostName = $_ENV['DB_HOST_NAME'];
        $dbPassword = $_ENV['DB_PASSWORD'];
        $dbUserName = $_ENV['DB_USER_NAME'];
        $dbName = $_ENV['DB_NAME'];
        $dsn = "mysql:host=" . $dbHostName . "; port=3307; dbname=" . $dbName . ";charset=utf8mb4;";

        $this->connection = new PDO($dsn, $dbUserName, $dbPassword);
    }

    public function &getConnection(): PDO
    {
        return $this->connection;
    }
}
