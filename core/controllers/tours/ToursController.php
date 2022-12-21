<?php

namespace core\controllers\tours;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\views\tours\ToursView;
use core\models\tours\ToursModel;
use core\models\hotels\HotelsModel;
use core\models\buses\BusesModel;
use core\models\managers\ManagersModel;

class ToursController extends BaseController implements ControllerInterface
{
    public function new(string $resortName = "", int $is_active = 0): void
    {
        $data = [
            'title' => 'Добавить тур',
            'header' => 'Добавить тур',
            'login' => $_COOKIE['login']
        ];

        $this->setView(ToursView::class);
        $this->view->render("tours/new.html.twig", $data);
    }
    public function edit(): void
    {
    }
    public function create(): void
    {
    }
    public function read(int $id = 0): void
    {
    }
    public function update(int $id = 0): void
    {
    }
    public function delete(int $id = 0): void
    {
    }
}
