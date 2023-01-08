<?php

namespace core\services;

class IdGetter
{
    public static function getId(): int|string
    {
        return filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_NUMBER_INT);
    }
}
