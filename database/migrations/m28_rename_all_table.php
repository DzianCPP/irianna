<?php

declare(strict_types=1);

namespace database\migrations;

use core\application\Database;

final class m28_rename_all_table extends BaseMigration
{
    private array $tables = [
        'admins' => 'admins_table',
        'buses' => 'buses_table',
        'clients_archive' => 'clients_archive_table',
        'clients' => 'clients_table',
        'contracts' => 'contracts_table',
        'countries' => 'countries_table',
        'hotels' => 'hotels_table',
        'managers' => 'managers_table',
        'resorts' => 'resorts_table',
        'rooms ' => 'rooms_table',
        'subclients_archive' => 'subclients_archive_table',
        'subclients' => 'subclients_table',
        'templates' => 'templates_table',
        'tours_archive' => 'tours_archive_table',
        'tours' => 'tours_table'
    ];

    public function up(): bool
    {
        $conn = Database::getInstance()->getConnection();

        foreach ($this->tables as $key => $value) {
            $sql = "RENAME TABLE IF EXISTS $value TO $key";
            echo $sql . PHP_EOL;
            $query = $conn->prepare($sql);

            try {
                $query->execute();
            } catch (\PDOException $e) {
                echo $e->getMessage() . PHP_EOL;
                $this->down();

                return false;
            }
        }

        $this->migrationHistoryHandler->addMigrationToHistory($conn, self::class);
        return true;
    }

    public function down(): bool
    {
        $conn = Database::getInstance()->getConnection();

        foreach ($this->tables as $key => $value) {
            $sql = "RENAME TABLE IF EXISTS $key TO $value";
            $query = $conn->prepare($sql);

            try {
                $query->execute();
                $this->migrationHistoryHandler->removeMigrationFromHistory($conn, self::class);
            } catch (\PDOException $e) {
                echo $e->getMessage() . PHP_EOL;
                echo "Could not rename $key into $value";

                return false;
            }
        }

        return true;
    }
}