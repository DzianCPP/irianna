<?php

namespace database\migrations;

use core\application\Database;

class m24_modify_clients_and_subclients_tables_drop_archive_tables extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQueries = [
            'alter_clients' => "
                ALTER TABLE clients_table
                ADD COLUMN IF NOT EXISTS (archived bool DEFAULT false);
            ",
            'alter_subclients' => "
                ALTER TABLE subclients_table
                ADD COLUMN IF NOT EXISTS (archived bool DEFAULT false);
            "
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
            'alter_subclients' => "
                ALTER TABLE subclients_table DROP COLUMN IF EXISTS archived;
            ",
            'alter_clients' => "
                ALTER TABLE clients_table DROP COLUMN IF EXISTS archived;
            "
        ];

        foreach ($sqlQueries as $sqlQuery) {
            $query = $conn->prepare($sqlQuery);

            try {
                $query->execute();
                $this->migrationHistoryHandler->removeMigrationFromHistory($conn, self::class);
            } catch (\PDOException $e) {
                return false;
            }
        }

        return true;
    }
}
