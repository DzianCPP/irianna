<?php

namespace database\migrations;

use core\application\Database;
use PDO;

class m5_create_hotels_table extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = "CREATE TABLE IF NOT EXISTS hotels_table(
                        id int(20) NOT NULL AUTO_INCREMENT,
                        name varchar(255) NOT NULL,
                        resort_id int(20) NOT NULL,
                        address varchar(1024) DEFAULT NULL,
                        area varchar(1024) DEFAULT NULL,
                        beach varchar(1024) DEFAULT NULL,
                        body varchar(1024) DEFAULT NULL,
                        number varchar(1024) DEFAULT NULL,
                        water varchar(1024) DEFAULT NULL,
                        food varchar(1024) DEFAULT NULL,
                        features varchar(1024) DEFAULT NULL,
                        description varchar(1024) DEFAULT NULL,
                        is_active int(1) NOT NULL DEFAULT '1',
                        PRIMARY KEY(id))";

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

        $sqlQuery = "DROP TABLE IF EXISTS hotels_table";

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
