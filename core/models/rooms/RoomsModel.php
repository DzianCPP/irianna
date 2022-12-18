<?php

namespace core\models\rooms;

use core\models\DatabaseSqlBuilder;
use core\models\Model;
use core\models\ModelInterface;
use core\models\rooms\RoomsValidator;

class RoomsModel extends Model implements ModelInterface
{
    protected array $fields = ['name', 'is_active', 'country_id', 'id'];
    private const TABLE_NAME = "rooms_table";

    public function __construct()
    {
        parent::__construct(RoomsValidator::class);
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
