<?php

namespace core\models\resorts;

use core\models\Validator;

class ResortsValidator extends Validator
{
    private string $ruTextRegexp = "/^[а-яёА-ЯЁ ,.'-]+$/i";

    public function isDataSafe(string $text = "", string $email = "", int|float $number = 0): bool
    {
        // $is_active = $number;

        // if (!is_numeric($is_active) || $is_active > 1 || $is_active < 0) {
        //     return false;
        // }

        return true;
    }
}
