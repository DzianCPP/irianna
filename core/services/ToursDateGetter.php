<?php

namespace core\services;

final class ToursDateGetter
{
    public static function getTourDay(array $tour = []): string
    {
        if (!$tour) {
            return date('d', strtotime('now'));
        }

        $day = explode('-', $tour['created_at'])[2];

        if (strlen($day) < 2) {
            $day = '0' . $day;
        }

        return $day;
    }

    public static function getTourMonth(array $tour = []): string
    {
        if (!$tour) {
            return date('m', strtotime('now'));
        }

        $month = explode('-', $tour['created_at'])[1];

        if (strlen($month) < 2) {
            $month = '0' . $month;
        }

        return $month;
    }

    public static function getTourYear(array $tour = []): string
    {
        if (!$tour) {
            return date('Y', strtotime('now'));
        }

        $year = explode('-', $tour['created_at'])[0];

        return $year;
    }
}