<?php

declare(strict_types=1);

namespace core\models\entries;

use core\application\Database;
use Google\Service\Analytics\Resource\Data;
use PDO;
use PDOException;

final class EntryModel
{
    private string $table = 'entries';
    private array $fields = ['id', 'room_id', 'dateFrom', 'dateTo', 'archived', 'status'];
    public const FREE = 'free';
    public const BUSY = 'busy';

    public function create(array $room): bool
    {
        $conn = Database::getInstance()->getConnection();
        $dates = str_split(
            str_replace(
                "\n",
                "",
                rtrim(
                    $room['checkin_checkout_dates'],
                    ", "
                )
            ),
            10
        );

        $entries = [];

        for ($i = 0; $i < count($dates);) {
            $entries[] = [
                'room_id' => (int) $room['id'],
                'dateFrom' => $this->convertDate($dates[$i]),
                'dateTo' => $this->convertDate($dates[$i + 1])
            ];

            $i += 2;
        }

        foreach ($entries as $entry) {
            $sql = "
                INSERT INTO $this->table (room_id, dateFrom, dateTo)
                VALUES (" . $entry['room_id'] . ", '" . $entry['dateFrom'] . "', '" . $entry['dateTo'] . "')
            ";

            try {
                $query = $conn->prepare($sql);
                $query->execute();
            } catch (PDOException $e) {
                return false;
            }
        }

        return true;
    }

    public function getByRoomId(int $roomId): array
    {
        $conn = Database::getInstance()->getConnection();
        $sql = <<<SQL
            SELECT *
            FROM entries
            WHERE room_id = $roomId
        SQL;

        $query = $conn->prepare($sql);

        try {
            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            return [];
        }
    }

    public function setEntryBusy(int $entryId): bool
    {
        $conn = Database::getInstance()->getConnection();
        $sql = <<<SQL
            UPDATE $this->table
            SET status = self::BUSY
            WHERE id = $entryId
        SQL;

        try {
            $query = $conn->prepare($sql);
            $result = $query->execute();

            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getEntryById(int $id): array
    {
        $conn = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM $this->table WHERE id = $id";

        try {
            $query = $conn->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC)[0];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getFreeEntriesByRoomId(int $roomId): array
    {
        $conn = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM $this->table WHERE room_id = $roomId AND status = 'free'";

        try {
            $query = $conn->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
                return [];
        }
    }

    private function convertDate(string $date): string
    {
        [$day, $month, $year] = explode('.', $date);

        return $year . '-' . $month . '-' . $day;
    }
}
