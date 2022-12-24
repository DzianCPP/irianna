<?php

namespace core\models\admins;

use core\models\Validator;

class AdminsValidator extends Validator
{
    public function isDataSafe(): bool
    {
        return true;
    }
}
