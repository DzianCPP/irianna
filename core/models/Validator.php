<?php

namespace core\models;

class Validator
{
    private string $nameRegEx = "/^[a-z ,.'-]+$/i";

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

    public function userDataValid(string $email, string $name): bool
    {
        if (!$this->nameValid($name) || !$this->emailValid($email)) {
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

    private function nameValid(string $name): bool
    {
        $firstName = substr($name, 0, strpos($name, " ", 0));
        $lastName = ltrim(substr($name, strpos($name, " ", 0), strlen($name)));

        if (!preg_match($this->nameRegEx, $firstName) || !preg_match($this->nameRegEx, $lastName)) {
            return false;
        }

        return true;
    }
}
