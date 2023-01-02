<?php

namespace core\models\countries;

use core\models\Validator;

class CountriesValidator extends Validator
{
    private string $nameRegEx = "\/[^A-zА-я ]/iu";

    public function isDataSafe(array $newCountry = []): bool
    {
        setlocale(LC_ALL, "ru_RU.UTF-8");
        if (!$this->isNameSafe($newCountry['name'])) {
            return false;
        }

        if (!$this->isStatusSafe($newCountry['is_active'])) {
            return false;
        }

        if (!$this->isIdSafe($newCountry['id'])) {
            return false;
        }

        return true;
    }

    private function isNameSafe(string $name = NULL): bool
    {
        if ($name == "" || $name == NULL) {
            return false;
        }

        if (preg_match($this->nameRegEx, $name) != 0) {
            return false;
        }

        return true;
    }

    private function isStatusSafe(string|int $status = NULL): bool
    {
        return true;
    }

    private function isIdSafe(string|int $id = NULL): bool
    {
        return true;
    }
}
