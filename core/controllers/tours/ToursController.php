<?php

namespace core\controllers\tours;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\models\contracts\ContractsModel;
use core\services\Paginator;
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
use DateTime;
use core\services\ContractMaker;

class ToursController extends BaseController implements ControllerInterface
{
    public function new (string $resortName = "", int $is_active = 0): void
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

        $page = Paginator::getPage();
        $pages = (int)ceil(count($tours) / parent::PER_PAGE);

        if ($page) {
            Paginator::limitRange($tours, self::PER_PAGE, $page);
        } else {
            Paginator::limitRange($tours, self::PER_PAGE);
        }


        $data = [
            'tours' => $tours,
            'entity' => 'tours',
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
            'currentPage' => $page,
            'pages' => $pages
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

        $resortsModel = new ResortsModel();
        $resort = $resortsModel->get(['column' => 'id', 'value' => $tour['resort_id']])[0];

        $hotelsModel = new HotelsModel();
        $hotel = $hotelsModel->get(['column' => 'id', 'value' => $tour['hotel_id']])[0];

        $busesModel = new BusesModel();
        $bus = $busesModel->get(['column' => 'id', 'value' => $tour['bus_id']])[0];

        $countriesModel = new CountriesModel();

        $managersModel = new ManagersModel();
        $manager = $managersModel->get(['column' => 'id', 'value' => $tour['manager_id']])[0];

        $sub_clients = $clientsModel->getSubClients(['column' => 'main_client_id', 'value' => $client['id']]);

        $contract = $contractsModel->get(columnValue: ['column' => 'label', 'value' => 'contract'])[0];
        $contract['html'] = htmlspecialchars_decode($contract['html'], ENT_QUOTES);
        $contract = $contract['html'];

        $fileName = 'contract.html.twig';
        $contractFileName = 'core/views/templates/components/' . $fileName;

        $fp = fopen(BASE_PATH . $contractFileName, 'w');
        fwrite($fp, $contract, strlen($contract));
        fclose($fp);

        $age_of_children = $tour['ages'] ?? $tour['ages'] || '--';

        $contractData = [
            'resort_name' => $resort['name'],
            'hotel_name' => $hotel['name'],
            'day' => date('d'),
            'month' => date('m'),
            'year' => date('Y'),
            'from_minsk_date' => $tour['from_minsk_date'],
            'arrival_to_minsk' => $bus['arrival_to_minsk'],
            'to_minsk_date' => $tour['to_minsk_date'],
            'manager_name' => $manager['name'],
            'client_name' => $client['name'],
            'total_people' => 1 + count($sub_clients),
            'number_of_children' => $tour['number_of_children'],
            'age_of_children' => $age_of_children,
            'passport_number' => $client['passport'],
            'main_phone' => $client['main_phone'],
            'second_phone' => $client['second_phone'],
            'service_cost_in_BYN' => $tour['total_travel_service_byn'],
            'tour_price_in_curr' => explode(' ', $tour['total_travel_cost_currency'])[0],
            'currency' => explode(' ', $tour['total_travel_cost_currency'])[1],
            'country' => $countriesModel->get(['column' => 'id', 'value' => $resort['country_id']])[0]['name']
        ];

        $contract = ContractMaker::prepareContract($contract, $contractData);
        $contract = '{% block contract %}' . $contract . '{% endblock %}'
        ;
        $fileName = 'contract.html.twig';
        $contractFileName = 'core/views/templates/components/' . $fileName;

        $fp = fopen(BASE_PATH . $contractFileName, 'w');
        fwrite($fp, $contract, strlen($contract));
        fclose($fp);

        $data = [
            'title' => 'Печать договора',
            'header' => 'печать договора',
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