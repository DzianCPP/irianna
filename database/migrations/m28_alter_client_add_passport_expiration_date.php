<?php

declare(strict_types=1);

namespace database\migrations;

use core\application\Database;

class m28_alter_client_add_passport_expiration_date extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQueries = [
            <<<SQL
                ALTER TABLE subclients_table ADD COLUMN passport_expiration_date varchar(255) default null
            SQL,
            <<<SQL
                ALTER TABLE clients_table ADD COLUMN passport_expiration_date varchar(255) default null
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
                ALTER TABLE subclients_table
                DROP COLUMN passport_expiration_date
            SQL,
            <<<SQL
                ALTER TABLE clients_table
                DROP COLUMN IF EXISTS passport_expiration_date
            SQL,
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