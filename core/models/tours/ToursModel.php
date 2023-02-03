<?php

namespace core\models\tours;

use core\models\Model;
use core\models\ModelInterface;

class ToursModel extends Model implements ModelInterface
{
    protected array $fields = [
        'created',
        'manager_id',
        'is_only_transit',
        'transit',
        'resort_id',
        'hotel_id',
        'checkin_date',
        'checkout_date',
        'count_of_day',
        'bus_id',
        'owner_id',
        'owner_travel_service',
        'owner_travel_cost',
        'number_of_children',
        'ages',
        'total_travel_service_byn',
        'total_travel_cost_byn',
        'total_travel_service_currency',
        'total_travel_cost_currency',
        'from_minsk_date',
        'to_minsk_date',
        'arrival_to_minsk',
        'room_id',
        'id'
    ];
    private const TABLE_NAME = "tours_table";

    public function get(array $columnValue = []): array
    {
        return $this->databaseSqlBuilder->select(self::TABLE_NAME);
    }

    public function update(array $newInfo): bool
    {
        $this->dataSanitizer->SanitizeData($newInfo);
        
        if (!$this->databaseSqlBuilder->update(self::TABLE_NAME, $this->fields, $newInfo, 'id')) {
            return false;
        }
        
        return true;
    }

    public function create(): bool
    {
        $tour = json_decode(file_get_contents("php://input"), true);
        $this->dataSanitizer->SanitizeData($tour);

        if (!$this->databaseSqlBuilder->insert($tour, $this->fields, self::TABLE_NAME)) {
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

    public function getLastTour(): array
    {
        $tour = $this->databaseSqlBuilder->selectLastRecord(self::TABLE_NAME, 'id');
        
        return $tour[0];
    }

    public function count(array $columnsValues): int
    {
        $where_clause = "";

        $columns = [];

        foreach($columnsValues['columns'] as $c) {
            $columns[] = $c . "=";
        }

        $values = [];

        foreach($columnsValues['values'] as $v) {
            $values[] = "'" . $v . "'";
        }

        $where_clause = $columns[0] . $values[0] . " AND " . $columns[1] . $values[1];
        
        $result =  $this->databaseSqlBuilder->count(self::TABLE_NAME, $where_clause)[0][0];

        return $result;
    }

    public function getLastTourId(): int
    {
        $id =  $this->databaseSqlBuilder->lastId(self::TABLE_NAME, 'id');

        return $id;
    }
}
