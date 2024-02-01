<?php

declare(strict_types=1);

namespace core\models\stamps;

use core\models\Model;
use core\models\ModelInterface;

final class StampsModel extends Model implements ModelInterface
{
    private array $fields = ['manager_id', 'path', 'id'];
    private string $table = 'stamps';
    public function get(array $columnValue = []): array
    {
        return [];
    }

    public function update(array $newInfo): bool
    {
        return true;
    }

    public function create(array $data = []): bool
    {
        if (!$data) {
            return false;
        }

        if (!$this->databaseSqlBuilder->insert($data, $this->fields, $this->table)) {
            return false;
        }

        return true;
    }

    public function delete(
        array $columnValues = [],
        string $column = "",
        mixed $value = NULL
    ): bool {
        return true;
    }

}