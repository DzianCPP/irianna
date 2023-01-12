<?php

namespace core\models\clients\helpers;

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
}