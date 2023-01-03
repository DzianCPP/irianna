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
        $newInfo = $this->validator->makeDataSafe($newInfo);

        if (!$this->validator->isDataSafe($newInfo)) {
            return false;
        }

        if (!$this->databaseSqlBuilder->update(self::TABLE_NAME, $this->fields, $newInfo, "id")) {
            return false;
        }

        return true;
    }

    public function create(): bool
    {
        $manager = json_decode(file_get_contents("php://input"), true);

        if (!$this->databaseSqlBuilder->insert(recordInfo: $manager, columns: $this->fields, tableName: self::TABLE_NAME)) {
            return false;
        }

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        return true;
    }
}
