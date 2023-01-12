<?php

namespace database\migrations;

use core\application\Database;
use PDO;

class m6_create_tours_table extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = "CREATE TABLE IF NOT EXISTS tours_table(
                        id int(11) NOT NULL AUTO_INCREMENT,
                        created date NOT NULL,
                        manager_id int(11) NOT NULL,
                        is_only_transit int(11) DEFAULT NULL,
                        transit varchar(100) NOT NULL,
                        resort_id int(11) NOT NULL,
                        hotel_id int(11) DEFAULT NULL,
                        checkin_date text(256) NOT NULL,
                        checkout_date text(256) NOT NULL,
                        count_of_day int(11) NOT NULL,
                        bus_id int(11) NOT NULL,
                        owner_id int(100) NOT NULL,
                        owner_travel_service int(11) NOT NULL,
                        owner_travel_cost int(11) NOT NULL,
                        number_of_children int(11) DEFAULT NULL,
                        ages varchar(255) DEFAULT NULL,
                        total_travel_service int(11) NOT NULL,
                        total_travel_cost int(11) NOT NULL,
                        from_minsk_date text(256) DEFAULT NULL,
                        to_minsk_date text(256) DEFAULT NULL,                        
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

        $sqlQuery = "DROP TABLE IF EXISTS tours_table";

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
