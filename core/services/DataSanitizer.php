<?php

namespace core\services;

class DataSanitizer
{
    public function SanitizeData(array &$data = []): void
    {
        foreach ($data as &$d) {
            $d = trim($d);
            $d = stripslashes($d);
            $d = str_replace(";", "", $d);
            if (str_contains($d, "@")) {
                $d = filter_var($d, FILTER_SANITIZE_EMAIL);
            }

            if (is_numeric($d)) {
                $d = (int) $d;
                $d = filter_var($d, FILTER_SANITIZE_NUMBER_INT);
            }
            $d = htmlspecialchars($d);
        }
    }
}