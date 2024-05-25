<?php

declare(strict_types=1);

namespace database\migrations;

use core\application\Database;

class m25_create_table_stamps extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = <<<SQL
            CREATE TABLE IF NOT EXISTS stamps (
                id int(11) AUTO_INCREMENT,
                manager_id int(11) NOT NULL,
                path VARCHAR(256) NOT NULL,
                CONSTRAINT fk_manager FOREIGN KEY (manager_id)
                    REFERENCES managers_table(id),
                PRIMARY KEY(id)
            )
        SQL;

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

        $sqlQuery = <<<SQL
            DROP TABLE IF EXISTS stamps
        SQL;

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