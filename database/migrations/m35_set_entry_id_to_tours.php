<?php

declare(strict_types=1);

namespace database\migrations;

use core\application\Database;
use PDO;
use PDOException;

final class m35_set_entry_id_to_tours extends BaseMigration
{
    public function up(): bool
    {
        $conn = Database::getInstance()->getConnection();
        $sqlSelectTours = "SELECT * FROm tours";

        try {
            $querySelectTours = $conn->prepare($sqlSelectTours);
            $querySelectTours->execute();
            $tours = $querySelectTours->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage() . PHP_EOL;

            return false;
        }

        if (!$tours) {
            return false;
        }

        foreach ($tours as &$tour) {
            if ($tour['room_id'] == 0) {
                continue;
            }

            if (!$this->setEntryId($tour)) {
                echo "Could not set entry_id fro tour: " . $tour['id'] . PHP_EOL;
            } else {
                if (!$this->updateEntryStatus($tour)) {
                    echo "Could not update entry status";
                }
            }
        }

        return true;
    }

    private function setEntryId(array &$tour): bool
    {
        $sqlSelectEntryId = "
            SELECT id
            FROM entries
            WHERE room_id = " . $tour['room_id'] . "
                AND dateFrom = '" . $this->modifyDate($tour['checkin_date']) . "'
                AND dateTo = '" . $this->modifyDate($tour['checkout_date']) . "'
            "
        ;

        $querySelectEntryId = Database::getInstance()->getConnection()->prepare($sqlSelectEntryId);
        $querySelectEntryId->execute();
        $entryId = $querySelectEntryId->fetchColumn();

        if (!$entryId) {
            return false;
        }

        $sqlUpdateTour = <<<SQL
            UPDATE tours
            SET entry_id = $entryId
            WHERE id = $tour[id]
        SQL;

        $queryUpdateTour = Database::getInstance()->getConnection()->prepare($sqlUpdateTour);
        try {
            $result = $queryUpdateTour->execute();

            if ($result) {
                $tour['entry_id'] = $entryId;
            }

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage() . PHP_EOL;

            echo $sqlUpdateTour . PHP_EOL;

            return false;
        }
    }

    private function updateEntryStatus(array &$tour): bool
    {
        $conn = Database::getInstance()->getConnection();
        $sql = 'UPDATE entries SET status = "BUSY" WHERE id = ' . $tour['entry_id'];
         try {
            $query = $conn->prepare($sql);
            $query->execute();
         } catch (PDOException $e) {
            echo "Could not update entry status for entry: " . $tour['entry_id'] . PHP_EOL;

            return false;
         }

         return true;
    }

    private function modifyDate(string $date): string
    {
        [$day, $month, $year] = explode('.', $date);

        return $year . '-' . $month . '-' . $day;
    }
}