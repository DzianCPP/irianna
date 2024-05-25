<?php

declare(strict_types=1);

namespace database\migrations;

use core\application\Database;

class m26_alter_hotels_and_rooms extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQueries = [
            <<<SQL
                ALTER TABLE hotels_table
                ADD COLUMN archived BOOL
            SQL,
            <<<SQL
                ALTER TABLE rooms_table
                ADD COLUMN archived BOOL
            SQL
        ];

        foreach ($sqlQueries as $sqlQuery) {
            $query = $conn->prepare($sqlQuery);

            if (!$this->trySqlQuery($query, $conn, self::class)) {
                return false;
            }
        }

        return true;
    }

    public function down(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQueries = [
            <<<SQL
                ALTER TABLE rooms_table
                DROP COLUMN IF EXISTS archived
            SQL,
            <<<SQL
                ALTER TABLE hotels_table
                DROP COLUMN IF EXISTS archived
            SQL
        ];

        foreach ($sqlQueries as $sqlQuery) {

            $query = $conn->prepare($sqlQuery);

            try {
                $query->execute();
                $this->migrationHistoryHandler->removeMigrationFromHistory($conn, self::class);
            } catch (\PDOException $e) {
                echo $e->getMessage() . PHP_EOL;
                return false;
            }
        }

        return true;
    }
}