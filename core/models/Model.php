<?php

namespace core\models;

use core\application\Database;
use core\services\DataSanitizer;
use PDO;

abstract class Model
{
    protected PDO $conn;
    protected Database $database;
    protected $validator;
    protected DatabaseSqlBuilder $databaseSqlBuilder;
    protected DataSanitizer $dataSanitizer;

    public function __construct()
    {
        $this->database = Database::getInstance();
        $this->conn = $this->database->getConnection();
        $this->databaseSqlBuilder = new DatabaseSqlBuilder();
        $this->dataSanitizer = new DataSanitizer();
    }
}
