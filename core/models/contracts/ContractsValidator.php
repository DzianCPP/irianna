<?php

namespace core\models\contracts;

use core\models\Validator;

class ContractsValidator extends Validator
{
    public function isDataSafe(): bool
    {
        return true;
    }
}
