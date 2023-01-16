<?php

namespace core\models\tours;

use core\models\DatabaseSqlBuilder;
use core\models\Model;
use core\models\ModelInterface;
use core\models\tours\ToursValidator;

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
        'from_minsk_date',
        'to_minsk_date'
    ];
    private const TABLE_NAME = "tours_table";

    public function __construct()
    {
        parent::__construct(ToursValidator::class);
    }

    public function get(array $columnValue = []): array
    {
        return $this->databaseSqlBuilder->select(self::TABLE_NAME);
    }

    public function update(array $newInfo): bool
    {
        return true;
    }

    public function create(): bool
    {
        $tour = json_decode(file_get_contents("php://input"), true);

        if (!$this->databaseSqlBuilder->insert($tour, $this->fields, self::TABLE_NAME)) {
            return false;
        }

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        return true;
    }

    public function getCountOfRegisteredTours(int $bus_id, string $date): int
    {
        return $this->databaseSqlBuilder->getCount(self::TABLE_NAME, columns: ["bus_id", "departure_from_minsk"], values: [$bus_id, $date]);
    }
}
