<?php

namespace database\migrations;

use core\application\Database;
use PDO;

class m4_create_resorts_table extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = "CREATE TABLE IF NOT EXISTS resorts_table(
                        id int(20) NOT NULL AUTO_INCREMENT,
                        name varchar(255) NOT NULL DEFAULT ' ',
                        country_id int(20) NOT NULL,
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

        $sqlQuery = "DROP TABLE IF EXISTS resorts_table";

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
