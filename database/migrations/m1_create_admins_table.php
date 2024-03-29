<?php

namespace database\migrations;

use core\application\Database;
use PDO;

class m1_create_admins_table extends BaseMigration
{
    public function up(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = "CREATE TABLE IF NOT EXISTS admins_table(
                        id int(20) NOT NULL AUTO_INCREMENT,
                        email varchar(255) NOT NULL,
                        login varchar(255) NOT NULL,
                        password varchar(255) default NULL,
                        privileges int(1) NOT NULL DEFAULT '0',
                        PRIMARY KEY(id))";

        $query = $conn->prepare($sqlQuery);

        if (!$this->trySqlQuery($query, $conn, get_class($this))) {
            return false;
        }

        return true;
    }

    public function down(): bool
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $sqlQuery = "DROP TABLE IF EXISTS admins_table";

        $query = $conn->prepare($sqlQuery);

        try {
            $query->execute();
            $this->migrationHistoryHandler->removeMigrationFromHistory($conn, get_class($this));
        } catch (\PDOException $e) {
            return false;
        }

        return true;
    }
}
