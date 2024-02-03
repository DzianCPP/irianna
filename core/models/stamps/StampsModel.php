<?php

declare(strict_types=1);

namespace core\models\stamps;

use core\models\Model;
use core\models\ModelInterface;
use core\application\Database;
use PDOException;

final class StampsModel extends Model implements ModelInterface
{
    private array $fields = ['manager_id', 'path', 'id'];
    private string $table = 'stamps';
    public function get(array $columnValue = []): array
    {
        return $this->databaseSqlBuilder->select($this->table, $columnValue);
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
        $conn = Database::getInstance()->getConnection();
        $sql = <<<SQL
            DELETE FROM stamps
            WHERE id = $columnValues[value]
        SQL;

        try {
            $query = $conn->prepare($sql);
            $query->execute();
        } catch (PDOException $e) {
            echo "Could not delete stamp";

            return false;
        }

        return true;
    }
}