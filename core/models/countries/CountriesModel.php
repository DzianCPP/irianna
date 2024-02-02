<?php

namespace core\models\countries;

use core\models\Model;
use core\models\ModelInterface;

class CountriesModel extends Model implements ModelInterface
{
    protected array $fields = ['name', 'is_active', 'id'];
    private const TABLE_NAME = "countries";

    public function get(array $columnValue = []): array
    {
        if ($columnValue != []) {
            return $this->databaseSqlBuilder->select(self::TABLE_NAME, columnValue: $columnValue);
        }

        return $this->databaseSqlBuilder->select(self::TABLE_NAME, $columnValue);
    }

    public function update(array $newInfo): bool
    {
        $this->dataSanitizer->SanitizeData($newInfo);

        if (!$this->databaseSqlBuilder->update(self::TABLE_NAME, $this->fields, column: "id", recordInfo: $newInfo)) {
            return false;
        }

        return true;
    }

    public function create(array $data = []): bool
    {
        $newCountryInfo = json_decode(file_get_contents("php://input"), true);
        $this->dataSanitizer->SanitizeData($newCountryInfo);

        $columns = [];

        foreach ($this->fields as $field) {
            if ($field != 'id') {
                $columns[] = $field;
            }
        }

        if (!$this->databaseSqlBuilder->insert(recordInfo: $newCountryInfo, columns: $columns, tableName: self::TABLE_NAME)) {
            return false;
        }

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        if (!$this->databaseSqlBuilder->delete(
            columnValues: $columnValues,
            tableName: self::TABLE_NAME
        )) {
            return false;
        }

        return true;
    }
}
