<?php

namespace database\migrations;

use core\application\Database;

class m17_modify_tours_table_ownerTravelCost_column extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = "ALTER TABLE tours_table MODIFY owner_travel_cost varchar(256), MODIFY total_travel_cost_byn varchar(256)";

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

        $sqlQuery = "ALTER TABLE tours_table MODIFY owner_travel_cost text(256), MODIFY total_travel_cost_byn text(256)";

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