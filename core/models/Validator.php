<?php

namespace core\models;

class Validator
{
    private string $loginRegExp = "/^[a-z ,.'-]+$/i";

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

    private function makeStringSafe($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);

        return htmlspecialchars($data);
    }

    public function userDataValid(string $email, string $login): bool
    {
        if (!$this->loginValid($login) || !$this->emailValid($email)) {
            return false;
        }

        return true;
    }

    private function emailValid(string $email): bool
    {
        if (empty($email)) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    private function loginValid(string $login): bool
    {
        $login = trim($login);

        // if (!preg_match($this->nameRegEx, $login)) {
        //     return false;
        // }

        if (!filter_var($login, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $this->loginRegExp]])) {
            return false;
        }

        return true;
    }
}
