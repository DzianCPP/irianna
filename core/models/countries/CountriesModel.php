<?php

namespace core\models\countries;

use core\models\Model;

class CountriesModel extends Model
{
    protected array $fields = ['name', 'is_active'];
    private const TABLE_NAME = "countries_table";

    public function getAllCountries(): array
    {
        return $this->selectAll(self::TABLE_NAME);
    }

    public function getCountryById(int $id): array
    {
        return $this->getRecordBy("id", $id, self::TABLE_NAME);
    }

    public function insertCountry(array $params = []): bool
    {
        if ($params === []) {
            $params = $this->validator->makeDataSafe($_POST);
        } else {
            $params = $this->validator->makeDataSafe($params);
        }

        if (!$this->insert($params, $this->fields, self::TABLE_NAME)) {
            return false;
        }

        return true;
    }

    public function editCountry($newUserData): bool
    {
        $params = $this->validator->makeDataSafe($newUserData);

        if (!$this->update(self::TABLE_NAME, $this->fields, $params, "id")) {
            return false;
        }

        return true;
    }

    public function deleteCountry(array $ids): bool
    {
        if (!$this->delete("id", $ids, self::TABLE_NAME)) {
            return false;
        }

        return true;
    }

    public function seedCountries(array $data): bool
    {
        $params = [
            'login' => $data['login'],
            'password' => $data['password'],
            'super_admin' => $data['super_admin']
        ];

        if (!$this->insertCountry($params)) {
            return false;
        }

        return true;
    }
}
