<?php

namespace core\controllers\tours;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\views\tours\ToursView;
use core\models\tours\ToursModel;
use core\models\hotels\HotelsModel;
use core\models\buses\BusesModel;
use core\models\managers\ManagersModel;
use core\models\countries\CountriesModel;
use core\models\resorts\ResortsModel;

class ToursController extends BaseController implements ControllerInterface
{
    public function new(string $resortName = "", int $is_active = 0): void
    {
        $managers = new ManagersModel();
        $countries = new CountriesModel();
        $resorts = new ResortsModel();
        $hotels = new HotelsModel();
        $buses = new BusesModel();

        $data = [
            'title' => 'Добавить тур',
            'header' => 'Добавить тур',
            'login' => $_COOKIE['login'],
            'managers' => $managers->get(),
            'countries' => $countries->get(),
            'resorts' => json_encode($resorts->get()),
            'hotels' => json_encode($hotels->get()),
            'buses' => $buses->get()
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
