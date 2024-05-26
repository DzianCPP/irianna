<?php

namespace core\models\managers;

use core\models\Model;
use core\models\ModelInterface;

class ManagersModel extends Model implements ModelInterface
{
    protected array $fields = ['name', 'id'];

    private const TABLE_NAME = "managers_table";

    public function get(array $columnValue = []): array
    {
        if ($columnValue != []) {
            return $this->databaseSqlBuilder->select(self::TABLE_NAME, columnValue: $columnValue);
        }

        return $this->databaseSqlBuilder->select(self::TABLE_NAME);
    }

    public function update(array $newInfo): bool
    {
        $this->dataSanitizer->SanitizeData($newInfo);

        if (!$this->databaseSqlBuilder->update(self::TABLE_NAME, $this->fields, $newInfo, "id")) {
            return false;
        }

        return true;
    }

    public function create(array $data = []): bool
    {
        $manager = json_decode(file_get_contents("php://input"), true);
        $this->dataSanitizer->SanitizeData($manager);

        if (!$this->databaseSqlBuilder->insert(recordInfo: $manager, columns: $this->fields, tableName: self::TABLE_NAME)) {
            return false;
        }

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        if (!$this->databaseSqlBuilder->delete($columnValues, self::TABLE_NAME)) {
            return false;
        }

        return true;
    }
}
