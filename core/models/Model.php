<?php

namespace core\models;

use core\application\Database;
use PDO;

class Model
{
    protected PDO $conn;
    protected Database $database;
    protected Validator $validator;

    public function __construct()
    {
        $this->database = Database::getInstance();
        $this->validator = new Validator();
        $this->conn = $this->database->getConnection();
    }

    public function insert(array $params, array $fields, string $tableName): bool
    {
        if (!$this->validator->userDataValid($params['email'], $params['login'])) {
            return false;
        }

        $tableFields = $this->getTableFields($fields);
        $values = $this->getValues($params);
        $sqlQuery = "INSERT INTO ${tableName} (${tableFields})
                    VALUES (${values}, false)";
        $query = $this->conn->prepare($sqlQuery);
        if (!$query->execute()) {
            return false;
        }

        return true;
    }

    public function selectAll(string $tableName): array
    {
        $sqlQuery = "SELECT * FROM $tableName";
        $query = $this->conn->prepare($sqlQuery);
        $query->execute();

        return $query->fetchAll();
    }

    protected function getRecordBy(string $colName, $value, string $tableName): array
    {
        $sqlQuery = "SELECT * FROM ${tableName} WHERE ${colName}=${value}";
        $query = $this->conn->prepare($sqlQuery);
        $query->execute();

        return $query->fetchAll();
    }

    protected function update(string $tableName, array $fields, array $params, $colName): bool
    {
        $sets = $this->getSets($fields);
        $sqlQuery = "UPDATE ${tableName}
            SET ${sets}
            WHERE ${colName}={$params[$colName]}
        ";
        $query = $this->conn->prepare($sqlQuery);
        unset($params['id']);

        if (!$this->validator->userDataValid($params['email'], $params['login'])) {
            return false;
        }

        if (!$query->execute($params)) {
            return false;
        }

        return true;
    }

    protected function delete(string $colName, array $values, string $tableName): bool
    {
        $values = implode(", ", $values);
        $sqlQuery = "DELETE FROM ${tableName} WHERE ${colName} IN (${values})";
        $query = $this->conn->prepare($sqlQuery);
        if (!$query->execute()) {
            return false;
        }

        return true;
    }

    private function getTableFields(array $fields): string
    {
        return implode(", ", $fields);
    }

    private function getValues(array $params): string
    {
        foreach ($params as &$param) {
            $param = "'" . $param . "'";
        }

        return implode(",", $params);
    }

    private function getSets(array $fields): string
    {
        foreach ($fields as &$field) {
            $field = $field . "=:" . $field;
        }

        return implode(",", $fields);
    }
}
