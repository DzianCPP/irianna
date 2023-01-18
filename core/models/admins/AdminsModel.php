<?php

namespace core\models\admins;

use core\models\ModelInterface;
use core\models\Model;
use core\models\admins\AdminsValidator;

class AdminsModel extends Model implements ModelInterface
{
    protected array $fields = ['email' => 'email', 'login' => 'login', 'password' => 'password', 'super_admin' => 'super_admin', 'id' => 'id'];
    private const TABLE_NAME = "admins_table";

    public function __construct()
    {
        parent::__construct(AdminsValidator::class);
    }

    public function get(array $columnValue = []): array
    {
        if ($columnValue != []) {
            return $this->databaseSqlBuilder->select(self::TABLE_NAME, columnValue: $columnValue);
        }

        return $this->databaseSqlBuilder->select(self::TABLE_NAME, $columnValue);
    }

    public function update(array $newInfo): bool
    {
        $newAdmin = $this->validator->makeDataSafe($newInfo);

        if (!$this->validator->isDataSafe($newAdmin['login'], number: $newAdmin['super_admin'], email: $newAdmin['email'])) {
            return false;
        }

        if (!$this->databaseSqlBuilder->update(self::TABLE_NAME, $this->fields, column: "id", recordInfo: $newAdmin)) {
            return false;
        }

        return true;
    }

    public function create(): bool
    {
        $newAdmin = json_decode(file_get_contents("php://input"), true);
        $newAdmin = $this->validator->makeDataSafe($newAdmin);

        if (!$this->validator->isDataSafe()) {
            return false;
        }

        $columns = [$this->fields['email'], $this->fields['login'], $this->fields['password']];

        if (!$this->databaseSqlBuilder->insert(recordInfo: $newAdmin, columns: $columns, tableName: self::TABLE_NAME)) {
            return false;
        }

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        $jsonString = file_get_contents("php://input");
        $ids = json_decode($jsonString, true);

        if (count($ids) < 1) {
            return false;
        }

        if (!$this->databaseSqlBuilder->delete(
            columnValues: $columnValues,
            tableName: self::TABLE_NAME
        )) {

            return false;
        }

        return true;
    }
}
