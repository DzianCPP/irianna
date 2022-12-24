<?php

namespace core\models\countries;

use core\models\Validator;

class CountriesValidator extends Validator
{
    public function isDataSafe(): bool
    {
        return true;
    }
}
