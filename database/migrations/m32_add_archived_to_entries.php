<?php

declare(strict_types=1);

namespace database\migrations;

use core\application\Database;

final class m32_add_archived_to_entries extends BaseMigration
{
    public function up(): bool
    {
        $conn = Database::getInstance()->getConnection();

        $sql = <<<SQL
            ALTER TABLE IF EXISTS entries
            ADD COLUMN IF NOT EXISTS archived BOOL DEFAULT 0
        SQL;

        try {
            $query = $conn->prepare($sql);

            $query->execute();
        } catch (\PDOException $e) {
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
            ALTER TABLE IF EXISTS entries
            DROP COLUMN IF EXISTS archived
        SQL;

        try {
            $query = $conn->prepare($sql);

            $query->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();

            return false;
        }

        $this->migrationHistoryHandler->removeMigrationFromHistory($conn, self::class);

        return true;
    }
}