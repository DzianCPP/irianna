<?php

namespace database\migrations;

use database\migrationHistory\MigrationHistoryHandler;
use PDO;

abstract class BaseMigration
{
    protected MigrationHistoryHandler $migrationHistoryHandler;

    public function __construct()
    {
        $this->migrationHistoryHandler = new MigrationHistoryHandler();
    }

    protected function trySqlQuery(\PDOStatement $query, PDO &$conn, string $className): bool
    {
        try {
            $query->execute();
            $this->migrationHistoryHandler->addMigrationToHistory($conn, $className);
        } catch (\PDOException $e) {
            echo $e->getMessage() . PHP_EOL;
            echo $e->getTrace() . PHP_EOL;
            return false;
        }

        return true;
    }
}
