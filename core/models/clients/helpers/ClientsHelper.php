<?php

namespace core\models\clients\helpers;

use core\models\DatabaseSqlBuilder;

class ClientsHelper
{
    public static function normalizeSubClients(array &$sub_clients_data): array
    {
        $sub_clients = [];

        for ($i = 0; $i < count($sub_clients_data['_names']); $i++) {
            $sub_clients[] = [
                'name' => $sub_clients_data['_names'][$i],
                'passport' => $sub_clients_data['_passport'][$i],
                'birth_date' => $sub_clients_data['_birthDates'][$i]
            ];
        }

        return $sub_clients;
    }

    public static function getLastClientId(string $table_name): int
    {
        $dbSqlBuilder = new DatabaseSqlBuilder();
        $clients = $dbSqlBuilder->select($table_name);

        return $clients[count($clients) - 1]['id'];
    }
}