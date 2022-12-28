<?php

namespace core\models\resorts;

use core\models\Validator;

class ResortsValidator extends Validator
{
    private $nameRegEx = "/[\x{0410}-\x{042F}]/u";


    public function isDataSafe(array $resort = []): bool
    {
        if (!$this->isNameSafe($resort['name'])) {
            return false;
        }

        if (!$this->isCountryIdSafe($resort['country_id'])) {
            return false;
        }

        if (!$this->isStatusSafe($resort['is_active'])) {
            return false;
        }

        if (isset($resort['id'])) {
            if (!$this->isIdSafe($resort['id'])) {
                return false;
            }
        }

        return true;
    }

    private function isNameSafe(string $name): bool
    {
        if (preg_match($this->nameRegEx, $name) == 0) {
            return false;
        }

        return true;
    }

    private function isCountryIdSafe(int $country_id): bool
    {
        if (filter_var($country_id, FILTER_VALIDATE_INT) != true) {
            return false;
        }

        return true;
    }

    private function isStatusSafe(int $is_active): bool
    {
        if ($is_active > 1 && $is_active < 0) {
            return false;
        }

        return true;
    }

    private function isIdSafe(int $id): bool
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return false;
        }

        return true;
    }
}
