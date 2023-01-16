<?php

namespace core\models\clients;

use core\models\clients\helpers\ClientsHelper;
use core\models\Model;
use core\models\ModelInterface;

class ClientsModel extends Model implements ModelInterface
{
    protected array $fields = [
        ["name", "main_phone", "second_phone", "passport", "birth_date", "address", "id"],
        ["name", "passport", "birth_date", "main_client_id", "id"]
    ];
    private const TABLE_NAMES = ["clients_table", "subclients_table"];

    public function __construct()
    {
        parent::__construct(ClientsValidator::class);
    }

    public function get(array $columnValue = []): array
    {
        $clients = [];

        if ($columnValue != []) {
            $clients  = $this->databaseSqlBuilder->select(self::TABLE_NAMES[0], columnValue: $columnValue);
        } else {
            $clients = $this->databaseSqlBuilder->select(self::TABLE_NAMES[0], $columnValue);
        }

        return ClientsHelper::denormalizeClients($clients);
    }

    public function update(array $newInfo): bool
    {
        if (!$this->databaseSqlBuilder->update(self::TABLE_NAMES[0], $this->fields[0], $newInfo, 'id')) {
            return false;
        }

        return true;
    }

    public function updateSubClients(array $newInfo): bool
    {
        $sub_clients = ClientsHelper::normalizeSubClients($newInfo);
        $sub_clients = ClientsHelper::addIds($sub_clients, $newInfo['_ids']);
        $main_client_id = (int)$newInfo['_main_client_ids'][0];

        foreach ($sub_clients as &$sc) {
            $sc['main_client_id'] = $main_client_id;
            if (!$this->databaseSqlBuilder->update(self::TABLE_NAMES[1], $this->fields[1], $sc, 'main_client_id')) {
                return false;
            }
        }

        return true;
    }

    public function create(): bool
    {
        $clients = json_decode(file_get_contents("php://input"), true);
        $main_client = $clients['main_client'];
        $sub_clients = ClientsHelper::normalizeSubClients($clients['sub_client']);

        if (!$this->databaseSqlBuilder->insert($main_client, $this->fields[0], self::TABLE_NAMES[0])) {
            return false;
        }

        $clientId = ClientsHelper::getLastClientId(self::TABLE_NAMES[0]);

        foreach ($sub_clients as $sc) {
            $sc['main_client_id'] = $clientId;
            if (!$this->databaseSqlBuilder->insert($sc, $this->fields[1], self::TABLE_NAMES[1])) {
                return false;
            }
        }

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        if (!$this->databaseSqlBuilder->delete($columnValues, self::TABLE_NAMES[0])) {
            return false;
        }

        return true;
    }

    public function getSubClients(array $columnValue = []): array
    {
        $sub_clients =  $this->databaseSqlBuilder->select(self::TABLE_NAMES[1], $columnValue);
        $sub_clients = ClientsHelper::denormalizeClients($sub_clients);

        return $sub_clients;
    }

    public function getLastClientId(): int
    {
        return ClientsHelper::getLastClientId(self::TABLE_NAMES[0]);
    }
}
