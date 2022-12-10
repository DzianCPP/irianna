<?php

namespace core\models\admins;

use core\models\Model;

class AdminsModel extends Model
{
    protected array $fields = ['email', 'login', 'password', 'super_admin'];

    public function getAllAdmins(): array
    {
        return $this->selectAll("admins_table");
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
