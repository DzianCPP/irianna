<?php

namespace core\models\tours;

use core\models\Validator;

class ToursValidator extends Validator
{
    public function isDataSafe(): bool
    {
        return true;
    }
}
