<?php

namespace core\models;

interface ValidatorInterface
{
    public function makeDataSafe(array $data): array;
    public function makeStringSafe(string &$text): string;
    public function isDataSafe(): bool;
}
