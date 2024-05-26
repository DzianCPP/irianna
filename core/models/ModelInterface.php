<?php

namespace core\models;

interface ModelInterface
{
    public function get(array $columnValue = []): array;
    public function update(array $newInfo): bool;
    public function create(array $data = []): bool;
    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool;
}
