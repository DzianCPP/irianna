<?php

namespace core\models;

use core\application\Database;
use PDO;

class DatabaseSqlBuilder
{
    protected PDO $conn;
    protected Database $database;
    protected Validator $validator;

    public function __construct()
    {
        $this->database = Database::getInstance();
        $this->conn = $this->database->getConnection();
    }

    public function insert(array $recordInfo, array $columns, string $tableName): bool
    {
        $tableColumns = $this->getTableFields($columns);
        $values = $this->getValues($recordInfo);
        $sqlQuery = "INSERT INTO ${tableName} (${tableColumns})
                    VALUES (${values})";
        $query = $this->conn->prepare($sqlQuery);
        if (!$query->execute()) {
            return false;
        }

        return true;
    }

    public function select(string $tableName, array $columnValue = []): array
    {
        $sqlQuery = "SELECT * FROM $tableName";
        if ($columnValue != []) {
            $column = $columnValue['column'];
            $value = $columnValue['value'];
            $sqlQuery .= " WHERE ${column}='${value}'";
        }
        $query = $this->conn->prepare($sqlQuery);
        $query->execute();

        return $query->fetchAll();
    }

    public function update(string $tableName, array $fields, array $recordInfo, $column): bool
    {
        $sets = $this->getSets($fields);
        $sqlQuery = "UPDATE ${tableName}
            SET ${sets}
            WHERE ${column}={$recordInfo[$column]}
        ";
        $query = $this->conn->prepare($sqlQuery);

        if (!$query->execute($recordInfo)) {
            return false;
        }

        return true;
    }

    public function delete(array $columnValues, string $tableName): bool
    {
        $values = implode(", ", $columnValues['values']);
        $column = $columnValues['column'];
        $sqlQuery = "DELETE FROM ${tableName} WHERE ${column} IN (${values})";
        $query = $this->conn->prepare($sqlQuery);
        if (!$query->execute()) {
            return false;
        }

        return true;
    }

    public function getCount(string $table_name, array $columns, array|int $values): int|bool|array
    {
        $sqlQuery = "SELECT COUNT(*) FROM $table_name WHERE $columns[0] = '$values[0]'";
        $query = $this->conn->prepare($sqlQuery);
        if (!$query->execute()) {
            return 0;
        }

        return $query->fetchAll(); 
    }

    public function lastId(string $tableName, string $column): int|array
    {
        $sql = "SELECT MAX($column) FROM $tableName";
        $query = $this->conn->prepare($sql);
        if (!$query->execute()) {
            return 0;
        }

        return $query->fetchAll()[0][0];
    }

    public function selectLastRecord(string $tableName = "", string $column = ""): array
    {
        $sql = "SELECT * FROM $tableName WHERE $column=(SELECT MAX($column) FROM $tableName)";
        $query = $this->conn->prepare($sql);
        if (!$query->execute()) {
            return 0;
        }

        return $query->fetchAll();
    }

    private function getTableFields(array $fields): string
    {
        $columns = [];

        foreach ($fields as $field) {
            if ($field != 'id') {
                $columns[] = $field;
            }
        }

        return implode(", ", $columns);
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

    public function count(string $table_name, string $where_clause): array
    {
        $sql = "SELECT * FROM $table_name WHERE $where_clause";
        $query = $this->conn->prepare($sql);
        if (!$query->execute()) {
            return 0;
        }

        return $query->fetchAll();
    }
}
