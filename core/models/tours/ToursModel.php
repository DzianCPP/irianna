<?php

namespace core\models\tours;

use core\models\DatabaseSqlBuilder;
use core\models\Model;
use core\models\ModelInterface;
use core\models\tours\ToursValidator;

class ToursModel extends Model implements ModelInterface
{
    protected array $fields = ['hotel_id', 'description', 'checkin_checkout_dates', 'comforts', 'food', 'id'];
    private const TABLE_NAME = "rooms_table";
    protected array $comforts = ['Телевизор', 'Холодильник', 'Кондиционер', 'Душ', 'Ванна', 'Джакузи', 'Туалет', 'Балкон', 'Чайник', 'Кухня'];
    protected array $food = ['Без питания', 'Завтрак', 'Обед', 'Ужин'];

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
        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        return true;
    }

    public function getCountOfRegisteredTours(int $bus_id, string $date): int
    {
        return $this->databaseSqlBuilder->getCount();
    }
}
