<?php

namespace core\models\admins;

use core\models\ModelInterface;
use core\models\Model;
use core\services\DataSanitizer;

class AdminsModel extends Model implements ModelInterface
{
    protected array $fields = ['email', 'login', 'password', 'privileges', 'id'];
    private const TABLE_NAME = "admins";

    public function get(array $columnValue = []): array
    {
        if ($columnValue != []) {
            return $this->databaseSqlBuilder->select(self::TABLE_NAME, columnValue: $columnValue);
        }

        return $this->databaseSqlBuilder->select(self::TABLE_NAME, $columnValue);
    }

    public function update(array $newInfo): bool
    {
        $newAdmin = $newInfo;
        $this->dataSanitizer->SanitizeData($newAdmin);

        if (!$this->databaseSqlBuilder->update(self::TABLE_NAME, $this->fields, column: "id", recordInfo: $newAdmin)) {
            return false;
        }

        return true;
    }

    public function create(array $data = []): bool
    {
        $newAdmin = json_decode(file_get_contents("php://input"), true);
        $this->dataSanitizer->SanitizeData($newAdmin);

        $columns = [$this->fields['email'], $this->fields['login'], $this->fields['password']];

        if (!$this->databaseSqlBuilder->insert(recordInfo: $newAdmin, columns: $columns, tableName: self::TABLE_NAME)) {
            return false;
        }

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        $jsonString = file_get_contents("php://input");
        $ids = json_decode($jsonString, true);
        $this->dataSanitizer->SanitizeData($ids);

        if (count($ids) < 1) {
            return false;
        }

        if (!$this->databaseSqlBuilder->delete(
            columnValues: $columnValues,
            tableName: self::TABLE_NAME
        )) {

            return false;
        }

        return true;
    }
}
