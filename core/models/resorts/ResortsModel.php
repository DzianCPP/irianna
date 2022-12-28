<?php

namespace core\models\resorts;

use core\models\Model;
use core\models\ModelInterface;
use core\models\resorts\ResortsValidator;

class ResortsModel extends Model implements ModelInterface
{
    protected $fields = ['name', 'country_id', 'is_active', 'id'];
    private const TABLE_NAME = "resorts_table";

    public function __construct()
    {
        parent::__construct(ResortsValidator::class);
    }

    public function get(array $columnValue = []): array
    {
        if ($columnValue != []) {
            return $this->databaseSqlBuilder->select(self::TABLE_NAME, $columnValue);
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
        $resort = file_get_contents("php://input");
        $resort = json_decode($resort, true);

        if (!$this->validator->isDataSafe($resort)) {
            return false;
        }

        if (!$this->databaseSqlBuilder->insert($resort, $this->fields, self::TABLE_NAME)) {
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
