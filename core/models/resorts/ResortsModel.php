<?php

namespace core\models\resorts;

use core\models\DatabaseSqlBuilder;
use core\models\Model;
use core\models\ModelInterface;
use core\models\resorts\ResortsValidator;

class ResortsModel extends Model implements ModelInterface
{
    protected array $fields = ['name', 'is_active', 'country_id', 'id'];
    private const TABLE_NAME = "resorts_table";

    public function __construct()
    {
        parent::__construct(ResortsValidator::class);
    }

    public function get(array $columnValue = []): array
    {
        if ($columnValue != 0) {
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
        $resort = file_get_contents("php://input");
        $resort = json_decode($resort);

        if (!$this->validator->isDataSafe()) {
            return false;
        }

        if (!$this->databaseSqlBuilder->insert($resort, $this->fields, self::TABLE_NAME)) {
            return false;
        }

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        return true;
    }
}
