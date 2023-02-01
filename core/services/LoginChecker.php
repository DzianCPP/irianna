<?php

namespace core\services;

class LoginChecker
{
    public function isLogged(): bool
    {
        if (isset($_COOKIE['logged']) && $_COOKIE['logged'] === "1") {
            return true;
        }

        return false;
    }
}