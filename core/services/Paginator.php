<?php

namespace core\services;

class Paginator
{
    public static function limitRecords(array $records): array
    {
        return $records;
    }

    public static function getPage(): int
    {
        $page = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_NUMBER_INT);
        if ($page == "") {
            $page = 1;
        }

        return $page;
    }

    public static function limitRange(array &$records, int $per_page, int $requestedPage = 1): void
    {
        $rangeStart = $requestedPage * $per_page - $per_page;
        $rangeEnd = $rangeStart + $per_page;

        $newRecords = [];
        for ($i = $rangeStart; $i < $rangeEnd && $i < count($records); ++$i) {
            $newRecords[] = $records[$i];
        }

        $records = $newRecords;
    }
}
