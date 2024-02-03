<?php

declare(strict_types=1);

namespace database\migrations;

use core\application\Database;
use Google\Service\GKEHub\MigrateSpec;
use PDO;
use PDOException;

final class m34_add_entry_id_to_tours extends BaseMigration
{
    public function up(): bool
    {
        $conn = Database::getInstance()->getConnection();
        $sql = <<<SQL
            ALTER TABLE IF EXISTS tours
            ADD COLUMN IF NOT EXISTS entry_id INT NOT NULL DEFAULT 0
        SQL;

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
        $conn = Database::getInstance()->getConnection();
        $sql = <<<SQL
            ALTER TABLE IF EXISTS tours
            DROP COLUMN IF EXISTS entry_id
        SQL;

        try {
            $query = $conn->prepare($sql);
            $query->execute();
        } catch (PDOException $e) {
            echo $e->getMessage(). PHP_EOL;

            return false;
        }

        $this->migrationHistoryHandler->removeMigrationFromHistory($conn, self::class);

        return true;
    }
}