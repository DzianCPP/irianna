<?php

namespace database\migrations;

use core\application\Database;
use PDO;

class m8_create_buses_table extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = "CREATE TABLE IF NOT EXISTS buses_table (
                        id int(11) NOT NULL AUTO_INCREMENT,
                        name varchar(255) NOT NULL,
                        route varchar(1024) NOT NULL,
                        places int(11) NOT NULL,
                        departure_from_minsk varchar(1024) DEFAULT NULL,
                        departure_from_resort varchar(1024) DEFAULT NULL,
                        arrival_tt_minsk varchar(1024) DEFAULT NULL,
                        PRIMARY KEY (id))";

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

        $sqlQuery = "DROP TABLE IF EXISTS buses_table";

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
