<?php

namespace core\models\countries;

use core\models\Validator;

class CountriesValidator extends Validator
{
    public function isDataSafe(string $text = "", string $email = "", int|float $number = 0): bool
    {
        $countryName = $text;

        if ($countryName === "") {
            return false;
        }

        if (!$this->textValid($countryName)) {
            return false;
        }

        $is_active = $number;

        if (!is_numeric($is_active) || $is_active > 1 || $is_active < 0) {
            return false;
        }

        return true;
    }
}
