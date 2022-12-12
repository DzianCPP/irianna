<?php

namespace core\models;

use core\application\Database;
use PDO;

abstract class Model
{
    protected PDO $conn;
    protected Database $database;
    protected $validator;
    protected DatabaseSqlBuilder $databaseSqlBuilder;

    public function __construct(string $validatorName)
    {
        $this->database = Database::getInstance();
        $this->validator = new $validatorName();
        $this->conn = $this->database->getConnection();
        $this->databaseSqlBuilder = new DatabaseSqlBuilder();
    }
}
