<?php

namespace core\models\buses;

use core\models\Validator;

class BusesValidator extends Validator
{
    public function isDataSafe(): bool
    {
        return true;
    }
}
