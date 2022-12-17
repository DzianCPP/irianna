<?php

namespace core\models\periods;

use core\models\Validator;

class PeriodsValidator extends Validator
{
    public function isDataSafe(): bool
    {
        return true;
    }
}
