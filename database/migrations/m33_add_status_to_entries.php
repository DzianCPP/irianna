<?php

declare(strict_types=1);

namespace database\migrations;

use core\application\Database;
use PDO;
use PDOException;

final class m33_add_status_to_entries extends BaseMigration
{
    public function up(): bool
    {
        $sql = <<<SQL
            ALTER TABLE IF EXISTS entries
            ADD COLUMN IF NOT EXISTS status VARCHAR(255) DEFAULT 'free'
        SQL;

        $conn = Database::getInstance()->getConnection();

        try {
            $query = $conn->prepare($sql);
            $query->execute();
        } catch (PDOException $e) {
            echo $e->getMessage() . PHP_EOL;

            return false;
        }

        $this->migrationHistoryHandler->addMigrationToHistory($conn, self::class);

        return true;
    }

    public function down(): bool
    {
        $sql = <<<SQL
            ALTER TABLE IF EXISTS entries
            DROP COLUMN IF EXISTS status
        SQL;

        $conn = Database::getInstance()->getConnection();

        try {
            $query = $conn->prepare($sql);
            $query->execute();
        } catch (PDOException $e) {
            echo $e->getMessage() . PHP_EOL;

            return false;
        }

        $this->migrationHistoryHandler->removeMigrationFromHistory($conn, self::class);

        return true;
    }
}