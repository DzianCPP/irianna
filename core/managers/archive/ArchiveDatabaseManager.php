<?php

declare(strict_types=1);

namespace core\managers\archive;

use Exception;
use PDO;
use core\application\Database;
use core\Dto\archive\ArchiveResultDto;

class ArchiveDatabaseManager
{
    private PDO $connection;

    private array $entities = [
        'buses' => 'buses_table',
        'hotels' => 'hotels_table',
        'clients' => 'clients_table',
        'tours' => 'tours_table',
        'countries' => 'countries_table',
        'resorts',
    ];

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function archive(array $entities): ArchiveResultDto
    {
        $this->connection->beginTransaction();

        try {
            foreach ($entities as $entity) {
                if (!in_array($entity, array_keys($this->entities))) {
                    continue;
                }

                $sql = 'UPDATE ' . $this->entities[$entity] . ' SET archived = 1';

                $this->connection->prepare($sql)->execute();
            }

            $this->connection->commit();

            $message = 'Successfully updated entities: '
                . implode(
                    separator: ',',
                    array: $entities,
                )
                . '.';

            $resultDto = new ArchiveResultDto(
                [
                    'code' => ArchiveResultDto::CODE_OK,
                    'status' => ArchiveResultDto::STATUS_SUCCESS,
                    'message' => $message,
                ]
            );
        } catch (Exception $e) {
            $this->connection->rollBack();

            $resultDto = new ArchiveResultDto(
                [
                    'code' => ArchiveResultDto::CODE_ERROR,
                    'status' => ArchiveResultDto::STATUS_FAILED,
                    'message' => $e->getMessage(),
                ]
            );
        }

        return $resultDto;
    }
}