<?php

namespace core\models;

use core\models\ValidatorInterface;

abstract class Validator implements ValidatorInterface
{
    private string $textRegExp = "/^[a-z ,.'-]+$/i";

    public function makeDataSafe(array $data): array
    {
        $userData = [];
        $keys = array_keys($data);
        $i = 0;
        foreach ($data as $dataElement) {
            $userData[$keys[$i]] = $this->makeStringSafe($dataElement);
            ++$i;
        }

        return $userData;
    }

    public function makeStringSafe(string &$text): string
    {
        $text = trim($text);
        $text = stripslashes($text);

        return htmlspecialchars($text);
    }

    abstract public function isDataSafe(string $text = "", string $email = "", int|float $number = 0): bool;

    protected function emailValid(string $email): bool
    {
        if (empty($email)) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    protected function textValid(string $text): bool
    {
        $text = trim($text);

        if (!filter_var($text, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $this->textRegExp]])) {
            return false;
        }

        return true;
    }
}
