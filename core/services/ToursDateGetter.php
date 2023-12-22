<?php

namespace core\services;

final class ToursDateGetter
{
    public static function getTourDay(array $tour = []): string
    {
        if (!$tour) {
            return '';
        }

        $day = substr(
            $tour['created'],
            0,
            strpos($tour['created'], '-', '0')
        );

        if (strlen($day) < 2) {
            $day = '0' . $day;
        }

        return $day;
    }

    public static function getTourMonth(array $tour = []): string
    {
        if (!$tour) {
            return '';
        }

        $month = substr(
            $tour['created'],
            strpos($tour['created'], '-', 0) + 1,
            strrpos($tour['created'], '-', 0) - 2
        );

        if (strlen($month) < 2) {
            $month = '0' . $month;
        }

        return $month;
    }

    public static function getTourYear(array $tour = []): string
    {
        if (!$tour) {
            return '';
        }

        $year = substr(
            $tour['created'],
            -4,
            4
        );

        return $year;
    }
}