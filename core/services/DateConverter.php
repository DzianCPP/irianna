<?php

namespace core\services;

class DateConverter
{
    public static function YMDtoDMY(string $date): string
    {
        $new_date = substr($date, 8, 2).'.'.substr($date, 5, 2).'.'.substr($date, 0, 4);
        return $new_date;
    }
}