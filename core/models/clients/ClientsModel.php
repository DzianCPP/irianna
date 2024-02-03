<?php

namespace core\models\clients;

use core\models\clients\helpers\ClientsHelper;
use core\models\Model;
use core\models\ModelInterface;

class ClientsModel extends Model implements ModelInterface
{
    protected array $fields = [
        ["name", "main_phone", "second_phone", "passport", "birth_date", "address", "travel_service", "travel_cost_currency_1", "travel_cost_currency_2", "id", "archived"],
        ["name", "passport", "birth_date", "travel_service", "travel_cost_currency_1", "travel_cost_currency_2", "main_client_id", "id", "archived"]
    ];
    private const TABLE_NAMES = ["clients_table", "subclients_table"];

    public function get(array $columnValue = []): array
    {
        $clients = [];

        if ($columnValue != []) {
            $clients  = $this->databaseSqlBuilder->select(self::TABLE_NAMES[0], $columnValue);
        } else {
            $clients = $this->databaseSqlBuilder->select(self::TABLE_NAMES[0], $columnValue);
        }

        return ClientsHelper::denormalizeClients($clients);
    }

    public function getByName(array $columnValue = []): array
    {
        $client = [];

        if ($columnValue != []) {
            $client = $this->databaseSqlBuilder->selectLike(self::TABLE_NAMES[0], $columnValue);
        } else {
            $client = $this->databaseSqlBuilder->selectLike(self::TABLE_NAMES[0], $columnValue);
        }

        return $client;
    }

    public function update(array $newInfo): bool
    {
        $newInfo['sub_client']['_main_client_ids'] = [$newInfo['main_client']['id']];
        if (!$this->updateSubClients($newInfo['sub_client'])) {
            return false;
        }

        $newInfo = $newInfo['main_client'];

        $this->dataSanitizer->SanitizeData($newInfo);

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
            $this->dataSanitizer->SanitizeData($sc);
            if (!$this->databaseSqlBuilder->update(self::TABLE_NAMES[1], $this->fields[1], $sc, 'main_client_id')) {
                return false;
            }
        }

        return true;
    }

    public function create(array $data = []): bool
    {
        $clients = json_decode(file_get_contents("php://input"), true);
        $main_client = $clients['main_client'];
        $main_client['archived'] = 0;
        $this->dataSanitizer->SanitizeData($main_client);
        $sub_clients = ClientsHelper::normalizeSubClients($clients['sub_client']);

        if (!$this->databaseSqlBuilder->insert($main_client, $this->fields[0], self::TABLE_NAMES[0])) {
            return false;
        }

        $clientId = ClientsHelper::getLastClientId(self::TABLE_NAMES[0]);

        foreach ($sub_clients as $sc) {
            $sc['main_client_id'] = $clientId;
            $this->dataSanitizer->SanitizeData($sc);
            $sc['archived'] = 0;
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

    public function deleteSubClients(int $main_client_id): bool
    {
        if (!$this->databaseSqlBuilder->delete(['column' => 'main_client_id', 'values' => [$main_client_id]], self::TABLE_NAMES[1])) {
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
