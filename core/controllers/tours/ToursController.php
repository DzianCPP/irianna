<?php

namespace core\controllers\tours;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\models\contracts\ContractsModel;
use core\views\tours\ToursView;
use core\models\tours\ToursModel;
use core\models\hotels\HotelsModel;
use core\models\buses\BusesModel;
use core\models\clients\ClientsModel;
use core\models\managers\ManagersModel;
use core\models\countries\CountriesModel;
use core\models\resorts\ResortsModel;
use core\models\rooms\RoomsModel;
use core\services\IdGetter;

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
        $this->setModel(ToursModel::class);
        $this->setView(ToursView::class);
        $tour = $this->model->get(columnValue: ['column' => 'id', 'value' => IdGetter::getId()])[0];
        $managers = new ManagersModel();
        $countries = new CountriesModel();
        $resorts = new ResortsModel();
        $hotels = new HotelsModel();
        $rooms = new RoomsModel();
        $buses = new BusesModel();
        $client = new ClientsModel();
        $client = $client->get(columnValue: [
            'column' => 'id',
            'value' => $tour['owner_id']
        ])[0];

        $sub_clients = new ClientsModel();
        $sub_clients = $sub_clients->getSubClients(columnValue: [
            'column' => 'main_client_id',
            'value' => $client['id']
        ]);

        // TODO add owner_travel_cost_currency field to DB and Model

        $data = [
            'tour' => $tour,
            'managers' => $managers->get(),
            'countries' => $countries->get(),
            'resorts' => json_encode($resorts->get()),
            'hotels' => json_encode($hotels->get()),
            'rooms' => json_encode($rooms->get()),
            'buses' => $buses->get(),
            'client' => $client,
            'sub_clients' => $sub_clients,
            'title' => 'Изменить тур',
            'header' => 'Изменить тур',
            'login' => $_COOKIE['login']
        ];

        $this->view->render("tours/edit.html.twig", $data);
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
        $this->setModel(ToursModel::class);

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$this->model->update($data)) {
            http_response_code(500);
            die();
        }

        return;
    }
    
    public function delete(int $id = 0): void
    {
        $this->setModel(ToursModel::class);
        $ids = json_decode(file_get_contents("php://input"), true);

        if (!$this->model->delete(columnValues: ['column' => 'id', 'values' => $ids])) {
            http_response_code(500);
            die();
        }

        return;
    }

    public function printContract(): void
    {
        $this->setModel(ToursModel::class);
        $tour = $this->model->getLastTour();
        $clientsModel = new ClientsModel();
        $client = $clientsModel->get(columnValue: ['column' => 'id', 'value' => $tour['owner_id']])[0];

        $contractsModel = new ContractsModel();
        $contract = $contractsModel->getContractInHTML('contract');

        $data = [
            'tour' => $tour,
            'client' => $client,
            'contract' => $contract,
            'title' => 'Печать договора',
            'header' => 'Печать договора',
            'login' => $_COOKIE['login']
        ];

        $this->setView(ToursView::class);
        $this->view->render("tours/print.html.twig", $data);
    }

    public function getCountOfRegisteredTours(): void
    {
        $this->setModel(ToursModel::class);
        $tour_identifiers = json_decode(file_get_contents("php://input"), true);
        echo $this->model->getCountOfRegisteredTours($tour_identifiers['bus_id'], $tour_identifiers['date']);
    }
}
