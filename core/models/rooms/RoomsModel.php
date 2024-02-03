<?php

namespace core\models\rooms;

use core\models\Model;
use core\models\ModelInterface;

class RoomsModel extends Model implements ModelInterface
{
    protected array $fields = ['hotel_id', 'description', 'checkin_checkout_dates', 'comforts', 'food', 'archived', 'id'];
    private const TABLE_NAME = "rooms_table";
    protected array $comforts = ['Телевизор', 'Холодильник', 'Кондиционер', 'Душ', 'Ванна', 'Джакузи', 'Туалет', 'Балкон', 'Чайник', 'Кухня'];
    protected array $food = ['Без питания', 'Завтрак', 'Обед', 'Ужин'];

    public function get(array $columnValue = []): array
    {
        if ($columnValue != []) {
            return $this->databaseSqlBuilder->select(self::TABLE_NAME, columnValue: $columnValue);
        }

        return $this->databaseSqlBuilder->select(self::TABLE_NAME);
    }

    public function update(array $newInfo): bool
    {
        $room = $newInfo;

        $room['comforts'] = str_replace("\n", ", ", $room['comforts']);
        $room['food'] = str_replace("\n", ", ", $room['food']);
        $room['checkin_checkout_dates'] = rtrim($room['checkin_checkout_dates'], ", ");
        $room['archived'] = 0;
        $room['checkin_checkout_dates'] = str_replace("\n", "", $room['checkin_checkout_dates']);
        $room['checkin_checkout_dates'] = str_split($room['checkin_checkout_dates'], 10);

        foreach ($room['checkin_checkout_dates'] as &$date) {
            $date = "f" . $date;
        }

        $room['checkin_checkout_dates'] = implode(", ", $room['checkin_checkout_dates']);
        $this->dataSanitizer->SanitizeData($room);

        if (!$this->databaseSqlBuilder->update(self::TABLE_NAME, $this->fields, $room, "id")) {
            return false;
        }

        return true;
    }

    public function create(array $data = []): bool
    {
        $rooms = json_decode(file_get_contents("php://input"), true);
        foreach ($rooms as &$room) {
            // TODO move these three methods to a helper class
            $room['comforts'] = str_replace("\n", ", ", $room['comforts']);
            $room['food'] = str_replace("\n", ", ", $room['food']);
            $room['checkin_checkout_dates'] = str_replace("\n", ", ", $room['checkin_checkout_dates']);
            $room['checkin_checkout_dates'] = rtrim($room['checkin_checkout_dates'], ", ");
            $room['checkin_checkout_dates'] = explode(", ", $room['checkin_checkout_dates'], strlen($room['checkin_checkout_dates']));
            foreach ($room['checkin_checkout_dates'] as &$date) {
                $date = "f" . $date;
            }

            $room['archived'] = 0;

            $room['checkin_checkout_dates'] = implode(", ", $room['checkin_checkout_dates']);
            $room['checkin_checkout_dates'] = str_replace("\n", "", $room['checkin_checkout_dates']);

            // foreach ($room as $attribute) {
            //     if ($attribute == NULL || $attribute == "") {
            //         continue 2;
            //     }
            // }

            $this->dataSanitizer->SanitizeData($room);
            if (!$this->databaseSqlBuilder->insert($room, $this->fields, self::TABLE_NAME)) {
                return false;
            }
        }

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        if (
            !$this->databaseSqlBuilder->delete(
            columnValues: $columnValues,
            tableName: self::TABLE_NAME
            )
        ) {

            return false;
        }

        return true;
    }

    public function getComforts(): array
    {
        return $this->comforts;
    }

    public function getFood(): array
    {
        return $this->food;
    }
}