<?php

namespace database\migrations;

use core\application\Database;

class m14_create_clients_archive_table extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = "CREATE TABLE IF NOT EXISTS clients_archive_table (
                        id int(11) NOT NULL AUTO_INCREMENT,
                        name text(1024) NOT NULL,
                        main_phone text(256) NOT NULL,
                        second_phone text(256) DEFAULT NULL,
                        passport text(256) NOT NULL,
                        birth_date text(256) NOT NULL,
                        address text(256) DEFAULT NULL,
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

        $sqlQuery = "DROP TABLE IF EXISTS clients_archive_table";

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
