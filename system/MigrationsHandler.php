<?php

namespace system;

use core\application\Database;
use PDO;
use Exception;

class MigrationsHandler
{

    private array $migrations = [];

    public function run(int $databaseVersion = -1): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $this->migrations = require __DIR__ . "/../bootstrap/migrations-list.php";

        if ($databaseVersion > count($this->migrations)) {
            echo "No such version of the database.\n";
            return false;
        }

        if ($databaseVersion === -1) {
            $databaseVersion = count($this->migrations);
        }

        if (!$this->migrationHistoryExists($conn)) {
            $fullMigrationName = "database\migrations\\" . $this->migrations[0]['m0'];
            $migrationObject = new $fullMigrationName();
            if (!$migrationObject->up()) {
                return false;
            }
        }

        $completedMigrations = $this->getCompletedMigrations($conn);

        if ($databaseVersion < (count($completedMigrations) - 1)) {
            if ($this->rollback($conn, $databaseVersion, $completedMigrations)) {
                return true;
            }
        } else {
            if ($this->update($conn, $databaseVersion, $completedMigrations)) {
                return true;
            }
        }

        return false;
    }

    private function rollback(PDO $conn, int $databaseVersion, array $completedMigrations): bool
    {
        for ($i = count($completedMigrations) - 1; $i > $databaseVersion; --$i) {
            $completedMigrations = $this->getCompletedMigrations($conn);
            $migration = $this->migrations[$i];
            $migrationIndex = "m" . (string)$i;
            $migrationName = $migration[$migrationIndex];

            $fullMigrationName = "database\migrations\\" . $migrationName;

            $migrationObject = new $fullMigrationName();
            if (!$migrationObject->down()) {
                continue;
            }
        }
        return true;
    }

    private function update(PDO $conn, int $databaseVersion, array $completedMigrations): bool
    {
        for ($i = 1; $i < $databaseVersion; ++$i) {
            $completedMigrations = $this->getCompletedMigrations($conn);
            $migration = $this->migrations[$i];
            $migrationIndex = "m" . (string)$i;
            $migrationName = $migration[$migrationIndex];

            if ($migrationIndex === $completedMigrations[$i - 1]['migrationIndex']) {
                continue;
            }

            $fullMigrationName = "database\migrations\\" . $migrationName;

            $migrationObject = new $fullMigrationName();
            if (!$migrationObject->up()) {
                continue;
            }
        }

        return true;
    }

    private function migrationHistoryExists(PDO &$conn): bool
    {
        $sqlQuery = "SELECT 1 FROM migrationHistory LIMIT 1";
        try {
            $result = $conn->query($sqlQuery);
        } catch (Exception $e) {
            return false;
        }

        if ($result !== false) {
            return true;
        }

        return false;
    }

    private function getCompletedMigrations(PDO &$conn): array
    {
        $sqlQuery = "SELECT * FROM migrationHistory";
        $query = $conn->prepare($sqlQuery);
        $query->execute();
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);
        $result = $query->fetchAll();
        return $result;
    }
}
