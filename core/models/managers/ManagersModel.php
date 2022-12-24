<?php

namespace core\models\managers;

use core\models\Model;
use core\models\ModelInterface;
use core\models\managers\ManagersValidator;

class ManagersModel extends Model implements ModelInterface
{
    protected array $fields = ['name', 'id'];

    private const TABLE_NAME = "managers_table";

    public function __construct()
    {
        parent::__construct(ManagersValidator::class);
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
