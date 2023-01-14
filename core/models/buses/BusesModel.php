<?php

namespace core\models\buses;

use core\models\Model;
use core\models\ModelInterface;
use core\models\buses\BusesValidator;

class BusesModel extends Model implements ModelInterface
{
    protected array $fields = [
        'name',
        'route',
        'places',
        'departure_from_minsk',
        'arrival_to_minsk',
        'id'
    ];

    private const TABLE_NAME = "buses_table";

    public function __construct()
    {
        parent::__construct(BusesValidator::class);
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
        if (!$this->databaseSqlBuilder->update(self::TABLE_NAME, $this->fields, $newInfo, 'id')) {
            return false;
        }

        return true;
    }

    public function create(): bool
    {
        $bus = json_decode(file_get_contents("php://input"), true);
        $bus['places'] = (int)$bus['places'];

        if (!$this->databaseSqlBuilder->insert($bus, $this->fields, self::TABLE_NAME)) {
            return false;
        }
        
        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        if (!$this->databaseSqlBuilder->delete($columnValues, self::TABLE_NAME)) {
            return false;
        }

        return true;
    }
}
