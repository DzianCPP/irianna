<?php

namespace core\models\managers;

use core\models\Validator;

class ManagersValidator extends Validator
{
    public function isDataSafe(): bool
    {
        return true;
    }
}
