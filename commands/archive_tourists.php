<?php

use core\application\Database;

require_once __DIR__ . '/../bootstrap/base-paths.php';
require_once BASE_PATH . 'vendor/autoload.php';

final class ClientArchiverCommand
{
    private ?PDO $connection = null;

    public function __construct()
    {
        echo "construct start" . PHP_EOL;
        $this->connection = (Database::getInstance())->getConnection();
        echo "construct over" . PHP_EOL;
    }

    public function execute(): void
    {
        echo "execute start" . PHP_EOL;
        if (!$this->archiveClients() || !$this->archiveSubClients()) {
            echo "failed to archive clients or sub_clients";
            return;
        }

        echo "execute over" . PHP_EOL;
    }

    private function archiveClients(): bool
    {
        if (!$this->connection->exec("UPDATE clients_table SET archived = 1")) {
            echo "error: could not archive clients" . PHP_EOL;
            return false;
        };

        echo "clients archived" . PHP_EOL;

        return true;
    }

    private function archiveSubClients(): bool
    {
        if (!$this->connection->exec("UPDATE subclients_table SET archived = 1")) {
            echo "error: could not archive subclients" . PHP_EOL;
            return false;
        }

        echo "subclients archived" . PHP_EOL;

        return true;
    }
}

$archiver = new ClientArchiverCommand();
$archiver->execute();
