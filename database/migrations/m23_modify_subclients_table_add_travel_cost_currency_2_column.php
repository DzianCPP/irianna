<?php

namespace database\migrations;

use core\application\Database;

class m23_modify_subclients_table_add_travel_cost_currency_2_column extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = "ALTER TABLE subclients_table ADD COLUMN IF NOT EXISTS travel_cost_currency_2 varchar(256);";

        $query = $conn->prepare($sqlQuery);

        if (!$this->trySqlQuery($query, $conn, self::class)) {
            return false;
        }

        return true;
    }

    public function down(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = "ALTER TABLE subclients_table DROP COLUMN IF EXISTS travel_cost_currency_2;";

        $query = $conn->prepare($sqlQuery);

        try {
            $query->execute();
            $this->migrationHistoryHandler->removeMigrationFromHistory($conn, self::class);
        } catch (\PDOException $e) {
            return false;
        }

        return true;
    }
}