<?php

namespace core\models\resorts;

use core\models\Validator;

class ResortsValidator extends Validator
{
    public function isDataSafe(array $resort = []): bool
    {
        return true;
    }
}
