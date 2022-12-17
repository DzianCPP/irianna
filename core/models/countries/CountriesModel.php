<?php

namespace core\models\countries;

use core\models\Model;
use core\models\ModelInterface;

class CountriesModel extends Model implements ModelInterface
{
    protected array $fields = ['name', 'is_active', 'id'];
    private const TABLE_NAME = "countries_table";

    public function __construct()
    {
        parent::__construct(CountriesValidator::class);
    }

    public function get(array $columnValue = []): array
    {
        return $this->databaseSqlBuilder->select(self::TABLE_NAME, $columnValue);
    }

    public function update(array $newInfo): bool
    {
        $newCountry = $this->validator->makeDataSafe($newInfo);

        if (!$this->validator->isDataSafe($newCountry['name'], number: $newCountry['is_active'])) {
            return false;
        }

        if (!$this->databaseSqlBuilder->update(self::TABLE_NAME, $this->fields, column: "id", recordInfo: $newCountry)) {
            return false;
        }

        return true;
    }

    public function create(): bool
    {
        $newCountryInfo = json_decode(file_get_contents("php://input"), true);
        $newCountryInfo = $this->validator->makeDataSafe($newCountryInfo);

        if (!$this->validator->isDataSafe(number: $newCountryInfo['is_active'])) {
            return false;
        }

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
