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
}