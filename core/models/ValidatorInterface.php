<?php

namespace core\models;

interface ValidatorInterface
{
    public function makeDataSafe(array $data): array;
    public function makeStringSafe(string &$text): string;
    public function isDataSafe(string $text = "", string $email = "", int|float $number = 0): bool;
}
