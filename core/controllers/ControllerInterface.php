<?php

namespace core\controllers;

interface ControllerInterface
{
    public function create(): void;
    public function read(int $id = 0): void;
    public function update(int $id = 0): void;
    public function delete(int $id = 0): void;
}
