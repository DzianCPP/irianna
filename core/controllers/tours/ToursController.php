<?php

namespace core\controllers\tours;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\views\tours\ToursView;
use core\models\tours\ToursModel;
use core\models\hotels\HotelsModel;
use core\models\buses\BusesModel;
use core\models\clients\ClientsModel;
use core\models\managers\ManagersModel;
use core\models\countries\CountriesModel;
use core\models\resorts\ResortsModel;
use core\models\rooms\RoomsModel;

class ToursController extends BaseController implements ControllerInterface
{
    public function new(string $resortName = "", int $is_active = 0): void
    {
        $managers = new ManagersModel();
        $countries = new CountriesModel();
        $resorts = new ResortsModel();
        $hotels = new HotelsModel();
        $buses = new BusesModel();
        $rooms = new RoomsModel();

        $data = [
            'title' => 'Добавить тур',
            'header' => 'Добавить тур',
            'login' => $_COOKIE['login'],
            'managers' => $managers->get(),
            'countries' => $countries->get(),
            'resorts' => json_encode($resorts->get()),
            'hotels' => json_encode($hotels->get()),
            'buses' => $buses->get(),
            'rooms' => json_encode($rooms->get())
        ];

        $this->setView(ToursView::class);
        $this->view->render("tours/new.html.twig", $data);
    }
    public function edit(): void
    {
    }
    public function create(): void
    {
        $this->setModel(ToursModel::class);
        if (!$this->model->create()) {
            http_response_code(500);
            die();
        }

        return;
    }
    
    public function read(int $id = 0): void
    {
        $this->setModel(ToursModel::class);
        $this->setView(ToursView::class);
        $tours = $this->model->get();
        $clients = new ClientsModel();
        $sub_clients = $clients->getSubClients();
        $clients = $clients->get();
        $hotels = new HotelsModel();
        $rooms = new RoomsModel();
        $resorts = new ResortsModel();
        $managers = new ManagersModel();
        $buses = new BusesModel();

        $data = [
            'tours' => $tours,
            'clients' => $clients,
            'hotels' => $hotels->get(),
            'rooms' => $rooms->get(),
            'resorts' => $resorts->get(),
            'managers' => $managers->get(),
            'buses' => $buses->get(),
            'sub_clients' => $sub_clients,
            'header' => 'Туры',
            'title' => 'Туры',
            'login' => $_COOKIE['login'],
            'currentPage' => $this->getPage()
        ];


        $this->view->render("tours/tours.html.twig", $data);
    }

    public function update(int $id = 0): void
    {
    }
    public function delete(int $id = 0): void
    {
    }

    public function getCountOfRegisteredTours(): void
    {
        $this->setModel(ToursModel::class);
        $tour_identifiers = json_decode(file_get_contents("php://input"), true);
        echo $this->model->getCountOfRegisteredTours($tour_identifiers['bus_id'], $tour_identifiers['date']);
    }
}
