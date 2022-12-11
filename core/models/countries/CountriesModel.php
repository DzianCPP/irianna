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

    public function getAdminById(int $id): array
    {
        return $this->getRecordBy("id", $id, "admins_table");
    }

    public function insertAdmin(array $params = []): bool
    {
        if ($params === []) {
            $params = $this->validator->makeDataSafe($_POST);
        } else {
            $params = $this->validator->makeDataSafe($params);
        }

        if (!$this->insert($params, $this->fields, 'admins_table')) {
            return false;
        }

        return true;
    }

    public function editAdmin($newUserData): bool
    {
        $params = $this->validator->makeDataSafe($newUserData);

        if (!$this->update("admins_table", $this->fields, $params, "id")) {
            return false;
        }

        return true;
    }

    public function deleteAdmin(array $ids): bool
    {
        if (!$this->delete("id", $ids, "admins_table")) {
            return false;
        }

        return true;
    }

    public function seedAdmins(array $data): bool
    {
        $params = [
            'login' => $data['login'],
            'password' => $data['password'],
            'super_admin' => $data['super_admin']
        ];

        if (!$this->insertAdmin($params)) {
            return false;
        }

        return true;
    }
}
