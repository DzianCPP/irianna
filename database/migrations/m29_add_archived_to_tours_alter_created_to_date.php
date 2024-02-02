<?php

declare(strict_types=1);

namespace database\migrations;

use core\application\Database;

final class m29_add_archived_to_tours_alter_created_to_date extends BaseMigration
{
    public function up(): bool
    {
        $conn = Database::getInstance()->getConnection();

        $sqlUpdateCurrentCreated = "UPDATE tours SET created = '2023-01-01'";
        $sqlAddArchived = "ALTER TABLE IF EXISTS tours ADD COLUMN IF NOT EXISTS archived BOOL DEFAULT 0";
        $sqlChangeCreatedType = "ALTER TABLE IF EXISTS tours MODIFY IF EXISTS created DATE DEFAULT CURDATE()";

        $queryUpdateCurrentCreated = $conn->prepare($sqlUpdateCurrentCreated);
        $queryAddArchived = $conn->prepare($sqlAddArchived);
        $queryChangeCreatedType = $conn->prepare($sqlChangeCreatedType);
        try {
            $queryUpdateCurrentCreated->execute();
            $queryAddArchived->execute();
            $queryChangeCreatedType->execute();
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

        $sqlDropArchived = "ALTER TABLE IF EXISTS tours DROP COLUMN IF EXISTS archived";
        $sqlChangeCreatedType = "ALTER TABLE IF EXISTS tours MODIFY IF EXISTS created TEXT DEFAULT NULL";

        $queryDropArchived = $conn->prepare($sqlDropArchived);
        $queryChangeCreatedType = $conn->prepare($sqlChangeCreatedType);

        try {
            $queryDropArchived->execute();
            $queryChangeCreatedType->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage() . PHP_EOL;
            $this->migrationHistoryHandler->removeMigrationFromHistory($conn, self::class);

            return false;
        }


        return true;
    }
}
