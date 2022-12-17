<?php

namespace database\migrations;

use core\application\Database;
use PDO;

class m7_create_managers_table extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = "CREATE TABLE IF NOT EXISTS managers_table (
                        id int(11) NOT NULL AUTO_INCREMENT,
                        name varchar(64) NOT NULL,
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

        $sqlQuery = "DROP TABLE IF EXISTS managers_table";

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
