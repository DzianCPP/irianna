<?php

namespace core\models\periods;

use core\models\Model;
use core\models\ModelInterface;
use core\models\periods\PeriodsValidator;

class PeriodsModel extends Model implements ModelInterface
{
    protected array $fields = [
        'date',
        'bus_id',
        'transit_type',
        'id'
    ];

    private const TABLE_NAME = "periods_table";

    public function __construct()
    {
        parent::__construct(PeriodsValidator::class);
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
        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        return true;
    }
}
