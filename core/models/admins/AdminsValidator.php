<?php

namespace core\models\admins;

use core\models\Validator;

class AdminsValidator extends Validator
{
    private string $textRegExp = "/^[a-z ,.'-]+$/i";

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

        if ($email == "") {
            return false;
        }

        if (!$this->emailValid($email)) {
            return false;
        }

        return true;
    }
}
