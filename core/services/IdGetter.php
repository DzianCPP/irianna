<?php

namespace core\services;

class IdGetter
{
    public static function getId(): int|string
    {
        $id =  filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_NUMBER_INT);

        if ($id == '') {
            return 0;
        }

        return $id;
    }
}
