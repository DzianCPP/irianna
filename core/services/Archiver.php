<?php

namespace core\services;

require_once __DIR__ . '/../../bootstrap/base-paths.php';
require_once BASE_PATH . 'vendor/autoload.php';

use core\application\Database;
use PDO;

class Archiver
{
    private Database $db;
    private PDO $conn;
    private const SEVEN_MONTHS = 18410000;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }

    public function archiveClient(): void
    {
        $old_tours = $this->getOldTours();
        $old_clients = $this->getOldClients($old_tours);
        $old_sub_clients = $this->getOldSubClients($old_clients);

        foreach($old_sub_clients as $osc) {
            $this->archiveSubClient($osc);
            $this->removeSubClient($osc);
        }

        unset($old_sub_clients);

        foreach($old_tours as $ot) {
            $this->archiveTour($ot);
        }

        unset($old_tours);

        foreach ($old_clients as $oc) {
            $sql = "INSERT INTO clients_archive_table (id, name, main_phone, second_phone, passport, birth_date, address)";
            $values = "'" . $oc['id'] . "', '" . $oc['name'] . "', '" . $oc['main_phone'] . "', '" . $oc['second_phone'] . "', '" . $oc['passport'] . "', '" . $oc['birth_date'] . "', '" . $oc['address'] . "'";
            $sql = $sql . "VALUES (" . $values . ")";
            $query = $this->conn->prepare($sql);
            $query->execute();

            $sql = "DELETE FROM clients_table WHERE id = " . (int)$oc['id'];
            $query = $this->conn->prepare($sql);
            $query->execute();
        }

        unset($old_clients);
        return;
    }

    public function archiveSubClient(array $old_sub_client): void
    {
        $sql = "INSERT INTO subclients_archive_table (id, main_client_id, name, passport, birth_date) VALUE (";
        $values = "'" . $old_sub_client['id'] . "', '" . $old_sub_client['main_client_id'] . "', '" . $old_sub_client['name'] . "', '" . $old_sub_client['passport'] . "', '" . $old_sub_client['birth_date'] . "'";
        $sql = $sql . $values . ")";

        $query = $this->conn->prepare($sql);
        $query->execute();
    }

    public function removeSubClient(array $old_sub_client): void
    {
        $query = $this->conn->prepare("DELETE FROM subclients_table WHERE id = " . (int)$old_sub_client['id']);
        $query->execute();
    }

    public function archiveTour(array $old_tour): void
    {
        $query = $this->conn->prepare("DELETE FROM tours_table WHERE id = " . (int)$old_tour['id']);
        $query->execute();
    }

    private function getOldTours(): array
    {
        $sql = "SELECT * FROM tours";
        $query = $this->conn->prepare($sql);
        $query->execute();
        $all_tours = $query->fetchAll();

        foreach($all_tours as &$at) {
            $at['to_minsk_date'] = strtotime($at['to_minsk_date']);
        }

        $old_tours = [];
        $today = time();

        foreach($all_tours as &$at) {
            if ($today - $at['to_minsk_date'] >= self::SEVEN_MONTHS) {
                $old_tours[] = $at;
            }
        }

        unset($all_tours);

        return $old_tours;
    }

    private function getOldClients(array $old_tours): array
    {
        $old_clients = [];

        foreach($old_tours as $ot) {
            $sql = "SELECT * FROM clients_table WHERE id = " . (int)$ot['owner_id'];
            $query = $this->conn->prepare($sql);
            $query->execute();
            $old_clients[] = $query->fetchAll()[0];
        }

        return $old_clients;
    }

    private function getOldSubClients(array $old_clients): array
    {
        $old_sub_clients = [];

        foreach($old_clients as $oc) {
            $sql = "SELECT * FROM clients_table WHERE main_client_id = " . (int)$oc['id'];
            $query = $this->conn->prepare($sql);
            $query->execute();
            $old_sub_clients[] = $query->fetchAll()[0];
        }

        return $old_sub_clients;
    }
}

$a = new Archiver();
$a->archiveClient();