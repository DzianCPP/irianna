<?php

declare(strict_types=1);

namespace database\migrations;

use core\application\Database;

final class m30_add_create_table_entries extends BaseMigration
{
    public function up(): bool
    {
        try {
            Database::getInstance()
                ->getConnection()
                ->prepare(
                    <<<SQL
                        CREATE TABLE IF NOT EXISTS entries (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            room_id INT NOT NULL,
                            dateFrom DATE NOT NULL,
                            dateTo DATE NOT NULL,
                            CONSTRAINT fk_room FOREIGN KEY (room_id) REFERENCES rooms(id)
                        )
                    SQL
                )
                ->execute()
            ;
        } catch (\PDOException $e) {
            echo $e->getMessage() . PHP_EOL;

            return false;
        }

        $conn = Database::getInstance()->getConnection();

        $this->migrationHistoryHandler->addMigrationToHistory(
            conn: $conn,
            className: self::class
        );

        return true;
    }

    public function down(): bool
    {
        try {
            Database::getInstance()
                ->getConnection()
                ->prepare(
                    <<<SQL
                        DROP TABLE IF EXISTS entries
                    SQL
                )
                ->execute()
            ;
        } catch (\PDOException $e) {
            echo $e->getMessage() . PHP_EOL;

            return false;
        }

        $conn = Database::getInstance()->getConnection();

        $this->migrationHistoryHandler->removeMigrationFromHistory(
            conn: $conn,
            className: self::class
        );

        return true;
    }
}