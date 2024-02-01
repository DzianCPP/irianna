<?php

namespace core\models\buses;

use core\models\Model;
use core\models\ModelInterface;

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

        $bus = $newInfo;

        $bus['departure_from_minsk'] = str_replace("\n", "", $bus['departure_from_minsk']);
        $bus['departure_from_minsk'] = str_split($bus['departure_from_minsk'], 10);
        $bus['departure_from_minsk'] = implode("\n", $bus['departure_from_minsk']);

        $bus['arrival_to_minsk'] = str_replace("\n", "", $bus['arrival_to_minsk']);
        $bus['arrival_to_minsk'] = str_split($bus['arrival_to_minsk'], 10);
        $bus['arrival_to_minsk'] = implode("\n", $bus['arrival_to_minsk']);

        if (!$this->databaseSqlBuilder->update(self::TABLE_NAME, $this->fields, $bus, 'id')) {
            return false;
        }

        return true;
    }

    public function create(array $data = []): bool
    {
        $bus = json_decode(file_get_contents("php://input"), true);
        $this->dataSanitizer->SanitizeData($bus);

        $bus['departure_from_minsk'] = str_replace("\n", "", $bus['departure_from_minsk']);
        $bus['departure_from_minsk'] = str_split($bus['departure_from_minsk'], 10);
        $bus['departure_from_minsk'] = implode("\n", $bus['departure_from_minsk']);

        $bus['arrival_to_minsk'] = str_replace("\n", "", $bus['arrival_to_minsk']);
        $bus['arrival_to_minsk'] = str_split($bus['arrival_to_minsk'], 10);
        $bus['arrival_to_minsk'] = implode("\n", $bus['arrival_to_minsk']);

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
