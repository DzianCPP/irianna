<?php

namespace core\models;

use PDO;
use PDOException;
use core\application\Database;

class DatabaseSqlBuilder
{
    protected PDO $conn;
    protected Database $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
        $this->conn = $this->database->getConnection();
    }

    public function insert(array $recordInfo, array $columns, string $tableName): bool
    {
        $tableColumns = $this->getTableFields($columns);
        $values = $this->getValues($recordInfo);
        $sqlQuery = "INSERT INTO $tableName ($tableColumns)
                    VALUES ($values)";
        $query = $this->conn->prepare($sqlQuery);
        try {
            $query->execute();
        } catch (PDOException $e) {
            return false;
        }

        return true;
    }

    public function select(
        string $tableName,
        array $columnValue = [],
        array $columnsValues = [],
        array $joins = []
    ): array {
        $sqlQuery = "SELECT $tableName.* FROM $tableName";

        if ($joins != []) {
            $joins = $this->setJoins($joins);
            $sqlQuery .= ' ' . $joins;
        }

        if ($columnValue != []) {
            $column = $columnValue['column'];
            $value = $columnValue['value'];
            $sqlQuery .= " WHERE {$column}='{$value}'";
        }


        if ($columnsValues != []) {
            $where_clause = $this->setWhereClause($columnsValues);
            $sqlQuery .= " WHERE $where_clause";
        }

        $query = $this->conn->prepare($sqlQuery);
        try {
            $query->execute();
        } catch (PDOException $e) {
            return [];
        }

        return $query->fetchAll();
    }

    public function selectLike(
        string $tableName,
        array $columnValue = []
    ): array {
        $sqlQuery = "SELECT * FROM " . $tableName;

        if (
            isset($columnValue)
            && $columnValue != []
            && !empty($columnValue)
        ) {
            $sqlQuery .= " WHERE " . $columnValue['column'] . ' LIKE \'%' . $columnValue['value'] . '%\'';
        }

        $sqlQuery .= ' LIMIT 1';

        $query = $this->conn->prepare($sqlQuery);

        try {
            $query->execute();
        } catch (PDOException $e) {
            return [];
        }

        return $query->fetchAll();
    }

    public function update(string $tableName, array $fields, array $recordInfo, $column): bool
    {
        $sets = $this->getSets($fields);
        $sqlQuery = "UPDATE {$tableName}
            SET {$sets}
            WHERE {$column}={$recordInfo[$column]}
        ";
        $query = $this->conn->prepare($sqlQuery);

        try {
            $query->execute($recordInfo);
        } catch (PDOException $e) {
            return false;
        }

        return true;
    }

    public function delete(array $columnValues, string $tableName): bool
    {
        $values = implode(", ", $columnValues['values']);
        $column = $columnValues['column'];
        $sqlQuery = "DELETE FROM {$tableName} WHERE {$column} IN ({$values})";
        $query = $this->conn->prepare($sqlQuery);
        try {
            $query->execute();
        } catch (PDOException $e) {
            return false;
        }

        return true;
    }

    public function getCount(string $table_name, array $columns, array|int $values): int|bool|array
    {
        $sqlQuery = "SELECT COUNT(*) FROM $table_name WHERE $columns[0] = '$values[0]'";
        $query = $this->conn->prepare($sqlQuery);
        try {
            $query->execute();
        } catch (PDOException $e) {
            return 0;
        }

        return $query->fetchAll();
    }

    public function lastId(string $tableName, string $column): int|array
    {
        $sql = "SELECT MAX($column) FROM $tableName";
        $query = $this->conn->prepare($sql);
        try {
            $query->execute();
        } catch (PDOException $e) {
            return 0;
        }

        return $query->fetchAll()[0][0];
    }

    public function selectLastRecord(string $tableName = "", string $column = ""): array
    {
        $sql = "SELECT * FROM $tableName WHERE $column=(SELECT MAX($column) FROM $tableName)";
        $query = $this->conn->prepare($sql);
        try {
            $query->execute();
        } catch (PDOException $e) {
            return [];
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

    private function setWhereClause(array $columnsValues): string
    {
        $where_clause = "";
        for ($i = 0; $i < count($columnsValues['columns']); $i++) {
            $item = $columnsValues['columns'][$i] . "='" . $columnsValues['values'][$i] . "' AND ";
            $where_clause .= $item;
        }

        $where_clause = rtrim($where_clause, " AND ");

        return $where_clause;
    }

    public function count(string $table_name, string $where_clause): array
    {
        $sql = "SELECT * FROM $table_name WHERE $where_clause";
        $query = $this->conn->prepare($sql);
        try {
            $query->execute();
        } catch (PDOException $e) {
            return [0];
        }

        return $query->fetchAll();
    }

    private function setJoins(array $joins = []): string
    {
        if (!$joins) {
            return "";
        }

        $joins_str = '';

        foreach ($joins as $join) {
            $joins_str .= 'LEFT JOIN ' . $join['table'] . ' ON ' . $join['left_table'] . '.' . $join['left_table_column'] . ' ' . $join['condition'] . ' ' . $join['table'] . '.' . $join['right_table_column'] . ' ';
        }

        return $joins_str;
    }

    public function selectDatesByHotelId(string $tableName, string $columnName, int $hotelId): array
    {
        $sql = "SELECT DISTINCT t.$columnName FROM $tableName AS t WHERE t.hotel_id = $hotelId";

        $query = $this->conn->prepare($sql);

        try {
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            return [];
        }

        return $result;
    }
}
