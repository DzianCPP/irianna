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
        if ($columnValue != []) {
            return $this->databaseSqlBuilder->select(self::TABLE_NAMES[0], columnValue: $columnValue);
        }

        return $this->databaseSqlBuilder->select(self::TABLE_NAMES[0], $columnValue);
    }

    public function update(array $newInfo): bool
    {
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

        foreach ($sub_clients as $sb) {
            $sb['main_client_id'] = $clientId;
            if (!$this->databaseSqlBuilder->insert($sb, $this->fields[1], self::TABLE_NAMES[1])) {
                return false;
            }
        }

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        return true;
    }
}
