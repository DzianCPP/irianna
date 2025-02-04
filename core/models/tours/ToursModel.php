<?php

namespace core\models\tours;

use core\application\Database;
use core\models\clients\ClientsModel;
use core\models\Model;
use core\models\ModelInterface;
use PDO;
use PDOException;

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
        'created_at',
        'id'
    ];
    private const TABLE_NAME = "tours_table";

    public function getDepartureFromMinskDatesByHotelId(int $hotelId): array
    {
        $result = $this->databaseSqlBuilder->selectDatesByHotelId(self::TABLE_NAME, 'from_minsk_date', $hotelId);

        return $result;
    }

    public function getDepartureFromHotelDatesByHotelId(int $hotelId): array
    {
        $result = $this->databaseSqlBuilder->selectDatesByHotelId(self::TABLE_NAME, 'to_minsk_date', $hotelId);

        return $result;
    }

    public static function getTableName(): string
    {
        return self::TABLE_NAME;
    }

    public function get(array $columnValue = []): array
    {
        if (!$columnValue) {
            return $this->databaseSqlBuilder->select(self::TABLE_NAME);
        }

        return $this->databaseSqlBuilder->select(
            tableName: self::TABLE_NAME,
            columnValue: $columnValue,
            joins: [
                [
                    'table' => 'clients_table',
                    'left_table' => 'tours_table',
                    'left_table_column' => 'owner_id',
                    'right_table_column' => 'id',
                    'condition' => '='
                ]
            ]
        );
    }

    public function search(): array
    {
        $params = json_decode(file_get_contents(BASE_PATH . "static/search/request.json"), true);
        $new_tours = $columnsValues = $columns = $values = [];
        foreach ($params as $k => $v) {
            if ($k != 'name') {
                $columns[] = $k;
                $values[] = $v;
            }
        }

        if (count($columns) > 0) {
            $columnsValues = ['columns' => $columns, 'values' => $values];
        }

        $tours = $this->databaseSqlBuilder->select(self::TABLE_NAME, columnsValues: $columnsValues);

        $filtered_tours = [];

        foreach ($tours as $t) {
            if ($t['archived'] == 0) {
                $filtered_tours[] = $t;
            }
        }

        $tours = array_reverse($filtered_tours);
        $clientsModel = new ClientsModel();

        if (isset($params['name'])) {
            foreach ($tours as $t) {
                $client = $clientsModel->get(['column' => 'id', 'value' => $t['owner_id']]);
                if ($client != []) {
                    $client = $client[0];
                    if (str_contains($client['name'], $params['name'])) {
                        $new_tours[] = $t;
                    }
                }
            }

            if (count($new_tours) > 0) {
                $tours = $new_tours;
                return $tours;
            } else {
                return [];
            }
        }

        return $tours;
    }

    public function update(array $newInfo): bool
    {
        $this->dataSanitizer->SanitizeData($newInfo);

        if (!$newInfo['created_at'] || empty($newInfo['created_at'])) {
            $newInfo['created_at'] = date('Y-m-d', strtotime('now'));
        }

        if (!$this->databaseSqlBuilder->update(self::TABLE_NAME, $this->fields, $newInfo, 'id')) {
            return false;
        }

        return true;
    }

    public function create(array $data = []): bool
    {
        $tour = json_decode(file_get_contents("php://input"), true);
        $this->dataSanitizer->SanitizeData($tour);
        $tour['created_at'] = date('Y-m-d', strtotime('now'));
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

        foreach ($columnsValues['columns'] as $c) {
            $columns[] = $c . "=";
        }

        $values = [];

        foreach ($columnsValues['values'] as $v) {
            $values[] = "'" . $v . "'";
        }

        $where_clause = $columns[0] . $values[0] . " AND " . $columns[1] . $values[1];

        $tours = $this->databaseSqlBuilder->count(self::TABLE_NAME, $where_clause);
        $total_people = count($tours);

        foreach ($tours as $t) {
            $main_client_id = $t['owner_id'];
            $count_sub_clients = count($this->databaseSqlBuilder->count('subclients_table', "main_client_id = $main_client_id"));
            $total_people += $count_sub_clients;
        }

        return $total_people;
    }

    public function getLastTourId(): int
    {
        $id = $this->databaseSqlBuilder->lastId(self::TABLE_NAME, 'id');

        return $id;
    }

    public function list(array $columnsValues = []): array
    {
        return $this->databaseSqlBuilder->select(tableName: self::TABLE_NAME, columnsValues: $columnsValues);
    }

    public function getTourByRoomIdAndDates(
        int $room_id,
        ?string $checkin_date,
        ?string $checkout_date
    ): array|false {
        if (!$room_id || !$checkin_date || !$checkout_date) {
            return false;
        }

        $table = self::TABLE_NAME;
        $sql = <<<SQL
            SELECT *
            FROM {$table}
            WHERE room_id = '{$room_id}'
                AND checkin_date LIKE '%{$checkin_date}%'
                AND checkout_date LIKE '%{$checkout_date}%'
            LIMIT 1
        SQL;

        $conn = Database::getInstance()->getConnection();

        try {
            $query = $conn->prepare($sql);
            $query->execute();
            $tour = $query->fetch(PDO::FETCH_ASSOC);

            if (!$tour) {
                return false;
            }

            return $tour;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(
                [
                    'status' => 500,
                    'message' => $e->getMessage()
                ]
            );

            return false;
        }
    }
}
