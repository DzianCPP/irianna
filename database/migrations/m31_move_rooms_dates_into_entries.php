<?php

declare(strict_types=1);

namespace database\migrations;

use core\application\Database;
use PDO;

final class m31_move_rooms_dates_into_entries extends BaseMigration
{
    public function up(): bool
    {
        $rooms = $this->getRooms();

        foreach ($rooms as $room) {
            $allDatesStr = str_replace('f', '', $room['checkin_checkout_dates']);
            $allDatesArray = explode(', ', $allDatesStr);
            $checkinDates = $this->getCheckinDates($allDatesArray);
            $checkoutDates = $this->getCheckoutDates($allDatesArray);
            $room['in'] = $checkinDates;
            $room['out'] = $checkoutDates;

            for ($i = 0; $i < count($room['in']); $i++) {
                $room_id = $room['id'];
                $dateFrom = $this->convertToMySQLDateFormat($room['in'][$i]);
                $dateTo = $this->convertToMySQLDateFormat($room['out'][$i]);
                echo $room_id . ' ' . $dateFrom . ' ' . $dateTo . ' ' . PHP_EOL;

                $sql = <<<SQL
                    INSERT INTO entries (room_id, dateFrom, dateTo)
                    VALUES ($room_id, '$dateFrom', '$dateTo')
                SQL;

                echo $sql . PHP_EOL;

                $query = $this->getConn()->prepare($sql);

                try {
                    $query->execute();
                } catch (\PDOException $e) {
                    echo $e->getMessage() . PHP_EOL;

                    return false;
                }
            }
        }

        $conn = $this->getConn();

        $this->migrationHistoryHandler->addMigrationToHistory($conn, self::class);

        return true;
    }

    public function down(): bool
    {
        $conn = $this->getConn();

        try {
            $conn->prepare("TRUNCATE entries")
                ->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage() . PHP_EOL;

            return false;
        }

        $this->migrationHistoryHandler->removeMigrationFromHistory($conn, self::class);

        return true;
    }

    private function getRooms(): array
    {
        $query = $this->getConn()->prepare(
            <<<SQL
                SELECT *
                FROM rooms
            SQL
        );

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getConn(): PDO
    {
        return Database::getInstance()->getConnection();
    }

    private function getCheckinDates(array $allDates): array
    {
        for ($i = 0; $i < count($allDates); $i = $i + 2) {
            $checkinDates[] = $allDates[$i];
        }

        return $checkinDates;
    }

    private function getCheckoutDates(array $allDates): array
    {
        for ($i = 1; $i <= count($allDates); $i = $i + 2) {
            $checkoutDates[] = $allDates[$i];
        }

        return $checkoutDates;
    }

    private function convertToMySQLDateFormat(string $date): string
    {
        [$day, $month, $year] = explode('.', $date);

        return $year . '-' . $month . '-' . $day;
    }
}