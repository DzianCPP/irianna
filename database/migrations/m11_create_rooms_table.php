<?php

namespace database\migrations;

use core\application\Database;
use PDO;

class m11_create_rooms_table extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = "CREATE TABLE IF NOT EXISTS rooms_table (
                        id int(11) NOT NULL AUTO_INCREMENT,
                        hotel_id int(20) NOT NULL,
                        description varchar(1024) DEFAULT NULL,
                        clients_ids text DEFAULT NULL,
                        checkin_checkout_dates text DEFAULT NULL,
                        comforts text DEFAULT NULL,
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

        $sqlQuery = "DROP TABLE IF EXISTS rooms_table";

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
