<?php

namespace core\models\hotels;

use core\models\Model;
use core\models\ModelInterface;

class HotelsModel extends Model implements ModelInterface
{
    protected array $fields = [
        'name',
        'resort_id',
        'address',
        'rooms',
        'area',
        'housing',
        'beach',
        'checkins',
        'water',
        'food',
        'features',
        'description',
        'is_active',
        'id'
    ];
    private const TABLE_NAME = "hotels_table";

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

    public function create(): bool
    {
        $hotel = json_decode(file_get_contents("php://input"), true);
        $columns = array_keys($hotel);
        $this->dataSanitizer->SanitizeData($hotel);
        if (!$this->databaseSqlBuilder->insert($hotel, $columns, self::TABLE_NAME)) {
            http_response_code(500);
            return false;
        }

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        if (!$this->databaseSqlBuilder->delete(
            [
                'column' => $columnValues['column'],
                'values' => $columnValues['values']
            ],
            self::TABLE_NAME
        )) {
            return false;
        }

        return true;
    }
}
