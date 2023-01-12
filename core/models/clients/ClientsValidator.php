<?php

namespace core\models\clients;

use core\models\Validator;

class ClientsValidator extends Validator
{
    public function isDataSafe(): bool
    {
        return true;
    }
}
