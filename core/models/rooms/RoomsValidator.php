<?php

namespace core\models\rooms;

use core\models\Validator;

class RoomsValidator extends Validator
{
    public function isDataSafe(): bool
    {
        return true;
    }
}
