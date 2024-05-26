<?php

namespace database\migrationHistory;

use PDO;

class MigrationHistoryHandler
{
    public function addMigrationToHistory(PDO &$conn, string $className): bool
    {
        $migrationName = ltrim($this->getMigrationName($className), "\\");
        $migrationIndex = $this->getMigrationIndex($migrationName);
        $sqlQuery = "INSERT INTO migrationHistory (migrationIndex, migrationName) VALUES ('$migrationIndex', '$migrationName')";

        if (!$this->executeQuery($conn, $sqlQuery)) {
            return false;
        }
        return true;
    }

    public function removeMigrationFromHistory(PDO &$conn, string $className): bool
    {
        $migrationName = ltrim($this->getMigrationName($className), "\\");
        $migrationIndex = $this->getMigrationIndex($migrationName);
        $sqlQuery = "DELETE FROM migrationHistory WHERE migrationIndex='$migrationIndex'";
        if (!$this->executeQuery($conn, $sqlQuery)) {
            return false;
        }

        return true;
    }

    private function getMigrationIndex(string $className): string
    {
        return substr($className, 0, strpos($className, "_", 0));
    }

    private function getMigrationName(string $className): string
    {
        return substr($className, strrpos($className, "\\"), strlen($className));
    }

    private function executeQuery(PDO &$conn, string $sqlQuery): bool
    {
        $query = $conn->prepare($sqlQuery);
        if (!$query->execute()) {
            return false;
        }
        return true;
    }
}
