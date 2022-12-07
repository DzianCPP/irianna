<?php

namespace core\controllers\buses;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;

class BusesController extends BaseController implements ControllerInterface
{
    public function create(): void
    {
        echo "created a bus";
    }

    public function read(int $id = 0): void
    {
        echo "here are buses";
    }

    public function update(int $id = 0): void
    {
        echo "updated bus";
    }

    public function delete(int $id = 0): void
    {
        echo "deleted bus";
    }
}
