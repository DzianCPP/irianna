<?php

namespace core\models\resorts;

use core\models\Validator;

class ResortsValidator extends Validator
{
    public function isDataSafe(): bool
    {
        return true;
    }
}
