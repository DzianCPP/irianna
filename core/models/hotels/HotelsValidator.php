<?php

namespace core\models\hotels;

use core\models\Validator;

class HotelsValidator extends Validator
{
    public function isDataSafe(): bool
    {
        return true;
    }
}
