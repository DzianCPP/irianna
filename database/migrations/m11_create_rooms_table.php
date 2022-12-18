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
                        client_id int(20) DEFAULT NULL,
                        checkin_date_1 date DEFAULT NULL,
                        checkin_date_2 date DEFAULT NULL,
                        checkin_date_3 date DEFAULT NULL,
                        checkin_date_4 date DEFAULT NULL,
                        checkin_date_5 date DEFAULT NULL,
                        checkin_date_6 date DEFAULT NULL,
                        checkin_date_7 date DEFAULT NULL,
                        checkin_date_8 date DEFAULT NULL,
                        checkin_date_9 date DEFAULT NULL,
                        checkin_date_10 date DEFAULT NULL,
                        checkout_date_1 date DEFAULT NULL,
                        checkout_date_2 date DEFAULT NULL,
                        checkout_date_3 date DEFAULT NULL,
                        checkout_date_4 date DEFAULT NULL,
                        checkout_date_5 date DEFAULT NULL,
                        checkout_date_6 date DEFAULT NULL,
                        checkout_date_7 date DEFAULT NULL,
                        checkout_date_8 date DEFAULT NULL,
                        checkout_date_9 date DEFAULT NULL,
                        checkout_date_10 date DEFAULT NULL,
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
