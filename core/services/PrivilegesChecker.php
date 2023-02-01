<?php

namespace core\services;

use core\models\admins\AdminsModel;

class PrivilegesChecker
{
    private AdminsModel $adminsModel;

    public function __construct()
    {
        $this->adminsModel = new AdminsModel();
    }
    
    public function getPrivileges(): int
    {
        $privileges = 0;

        $admin = $this->adminsModel->get(['column' => 'login', 'value' => $_COOKIE['login']])[0];

        $privileges = $admin['privileges'];
        
        return $privileges;
    }
}