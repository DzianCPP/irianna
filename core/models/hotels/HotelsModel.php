<?php

namespace core\models\hotels;

use core\models\Model;
use core\models\ModelInterface;
use core\models\hotels\HotelsValidator;

class HotelsModel extends Model implements ModelInterface
{
    protected array $fields = [
        'name',
        'resort_id',
        'address',
        'area',
        'beach',
        'body',
        'number',
        'water',
        'food',
        'features',
        'description',
        'is_active',
        'id'
    ];
    private const TABLE_NAME = "hotels_table";

    public function __construct()
    {
        parent::__construct(HotelsValidator::class);
    }

    public function get(array $columnValue = []): array
    {
        if ($columnValue != []) {
            return $this->databaseSqlBuilder->select(self::TABLE_NAME, columnValue: $columnValue);
        }

        return $this->databaseSqlBuilder->select(self::TABLE_NAME);
    }

    public function update(array $newInfo): bool
    {
        return true;
    }

    public function create(): bool
    {
        $hotel = json_decode(file_get_contents("php://input"), true);

        $columns = array_keys($hotel);

        $this->databaseSqlBuilder->insert($hotel, $columns, self::TABLE_NAME);

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        return true;
    }
}