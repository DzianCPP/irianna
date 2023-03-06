<?php

namespace core\controllers\clients;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\controllers\rooms\helpers\RoomsHelper;
use core\models\buses\BusesModel;
use core\models\hotels\HotelsModel;
use core\models\rooms\RoomsModel;
use core\models\tours\ToursModel;
use core\services\DateConverter;
use core\services\Paginator;
use core\views\clients\ClientsView;
use core\models\clients\ClientsModel;
use core\models\clients\helpers\ClientsHelper;
use core\services\IdGetter;
use core\views\tours\ToursView;

class ClientsController extends BaseController implements ControllerInterface
{
    public function new (): void
    {
        $data = [
            'title' => 'Добавить клиента',
            'header' => 'Добавить клиента',
            'login' => $_COOKIE['login']
        ];

        $this->setView(ClientsView::class);
        $this->view->render("clients/new.html.twig", $data);
    }

    public function edit(): void
    {
        $this->setModel(ClientsModel::class);
        $this->setView(ClientsView::class);

        $client = $this->model->get(columnValue: ['column' => 'id', 'value' => IdGetter::getId()])[0];

        $data = [
            'client' => $client,
            'sub_clients' => $this->model->getSubClients(columnValue: ['column' => 'main_client_id', 'value' => $client['id']]),
            'title' => "Изменить клиента",
            'login' => $_COOKIE['login'],
            'header' => "Изменить клиента"
        ];

        $this->view->render("clients/edit.html.twig", $data);
    }

    public function create(): void
    {
        $this->setModel(ClientsModel::class);
        if (!$this->model->create()) {
            http_response_code(500);
            die();
        }

        return;
    }

    public function read(int $id = 0): void
    {
        $this->setModel(ClientsModel::class);
        $clients = $this->model->get();

        $page = Paginator::getPage();
        $pages = (int) ceil(count($clients) / parent::PER_PAGE);

        if ($page) {
            Paginator::limitRange($clients, self::PER_PAGE, $page);
        } else {
            Paginator::limitRange($clients, self::PER_PAGE);
        }

        $data = [
            'title' => 'Клиенты',
            'entity' => 'clients',
            'header' => 'Клиенты',
            'login' => $_COOKIE['login'],
            'currentPage' => $page,
            'pages' => $pages,
            'clients' => $clients
        ];

        $this->setView(ClientsView::class);
        $this->view->render("clients/clients.html.twig", $data);
    }

    public function update(int $id = 0): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $this->setModel(ClientsModel::class);
        if (!$this->model->update($data)) {
            http_response_code(500);
            die();
        }

        return;
    }

    public function delete(int $id = 0): void
    {
        $this->setModel(ClientsModel::class);

        $ids = json_decode(file_get_contents("php://input"), true);

        foreach ($ids as $id) {
            if (!$this->model->deleteSubClients((int) $id)) {
                http_response_code(500);
                return;
            }
        }

        if (!$this->model->delete(columnValues: ['column' => 'id', 'values' => $ids])) {
            http_response_code(500);
            die();
        }

        return;
    }

    public function find(): void
    {
        $this->setModel(ClientsModel::class);
        $passport = json_decode(file_get_contents("php://input"), true);
        $client = $this->model->get(columnValue: ['column' => 'passport', 'value' => $passport])[0];
        echo (json_encode($client));
    }

    public function getLastClientId(): void
    {
        $this->setModel(ClientsModel::class);
        $id = $this->model->getLastClientId();
        echo json_encode($id);
    }

    public function updateSubClients(): void
    {
        $this->setModel(ClientsModel::class);
        if (!$this->model->updateSubClients(json_decode(file_get_contents("php://input"), true))) {
            http_response_code(500);
            die();
        }

        return;
    }

    public function passengers(): void
    {
        $busesModel = new BusesModel();
        $buses = $busesModel->get();

        $this->setView(ClientsView::class);
        $data = [
            'title' => 'Список пассажиров',
            'header' => 'Список пассажиров',
            'login' => $_COOKIE['login'],
            'buses' => $buses
        ];

        $this->view->render("passengers/form.html.twig", $data);
    }

    public function guests(): void
    {
        $hotelsModel = new HotelsModel();
        $hotels = $hotelsModel->get();

        $roomsModel = new RoomsModel();
        $rooms_sets = [];

        foreach ($hotels as $hotel) {
            $rooms_sets[] = $roomsModel->get(columnValue: ['column' => 'hotel_id', 'value' => $hotel['id']]);
        }

        $roomsHelper = new RoomsHelper();

        foreach ($rooms_sets as &$rooms) {
            foreach ($rooms as &$room) {
                $room = $roomsHelper->normalizeRoom($room);
            }
        }

        $this->setView(ClientsView::class);
        $data = [
            'title' => 'Список гостей',
            'header' => 'Список гостей',
            'login' => $_COOKIE['login'],
            'hotels' => $hotels,
            'rooms_sets' => json_encode($rooms_sets)
        ];

        $this->view->render("guests/form.html.twig", $data);
    }

    public function hotel_list(): void
    {
        $this->setModel(ClientsModel::class);
        $toursModel = new ToursModel();
        $roomsModel = new RoomsModel();
        $hotelsModel = new HotelsModel();
        $request_data = json_decode(file_get_contents("php://input"), true);
        $tours = $toursModel->get(columnValue: ['column' => 'hotel_id', 'value' => $request_data['hotel_id']]);
        foreach ($tours as &$tour) {
            if ($tour['checkin_date'] != $request_data['checkin_date'] && $tour['checkout_date'] != $request_data['checkout_date']) {
                unset($tour);
            }
        }

        $table_cells = [];
        $guests = [];
        foreach ($tours as $t) {
            $cell_html = "";
            $room = $roomsModel->get(['column' => 'id', 'value' => $t['room_id']]);
            $cell_html .= "<b><u>" . $room['description'] . "</u></b><br>";
            $guests[] = $main_client;

            // $main_client = $this->model->get(columnValue: ['column' => 'id', 'value' => $t['owner_id']]);
            // $cell_html .= "<b><u>{$main_client['name']}</u></b> - ";
            // $cell_html .= DateConverter::YMDtoDMY($main_client['birth_date']) . " - " . $main_client['passport'] . "<br>";

            // $sub_clients = $this->model->getSubClients(columnValue: ['column' => 'main_client_id', 'value' => $main_client['id']])[0];
            // foreach ($sub_clients as $sc) {
            //     $cell_html .= "<b><u>{$sc['name']}</u></b> - ";
            //     $cell_html .= DateConverter::YMDtoDMY($sc['birth_date']) . " - " . $sc['passport'] . "<br>";
            // }

            $table_cells[] = $cell_html;
        }

        $data = [
            'title' => 'Список гостей',
            'header' => 'Список гостей',
            'login' => $_COOKIE['login'],
            'guests' => $guests,
            'checkin_date' => $request_data['checkin_date'],
            'checkout_date' => $request_data['checkout_date'],
            'hotel' => $hotelsModel->get(columnValue: ['column' => 'id', 'value' => $request_data['hotel_id']])[0],
            'table_cells' => $table_cells
        ];

        $f = fopen(BASE_PATH . "static/passengers/passengers.json", 'w');
        if (!$f) {
            http_response_code(500);
            return;
        }

        fwrite($f, json_encode($data), strlen(json_encode($data)));
        fclose($f);

        http_response_code(200);
    }

    public function guests_list(): void
    {
        $this->setView(ClientsView::class);
        $data = json_decode(file_get_contents(BASE_PATH . "static/passengers/passengers.json"), true);
        $this->view->render("guests/guests.html.twig", $data);
    }

    public function list(): void
    {
        $this->setModel(ClientsModel::class);
        $data = json_decode(file_get_contents("php://input"), true);
        $toursModel = new ToursModel();
        $tours = $toursModel->list(columnsValues: [
            'columns' => ['bus_id', 'from_minsk_date', 'arrival_to_minsk'],
            'values' => [$data['bus_id'], $data['from_minsk_date'], $data['to_minsk_date']]
        ]);

        $main_clients = [];

        foreach ($tours as $tour) {
            $main_clients[] = $this->model->get(['column' => 'id', 'value' => $tour['owner_id']])[0];
        }

        $sub_clients = [];

        foreach ($main_clients as $mc) {
            $sub_clients[] = $this->model->getSubClients([
                'column' => 'main_client_id',
                'value' => $mc['id']
            ]);
        }

        $passengers = ['main_clients' => [], 'sub_clients' => []];

        for ($i = 0; $i < count($main_clients); $i++) {
            $passengers['main_clients'][] = $main_clients[$i];
            $passengers['sub_clients'][] = $sub_clients[$i];
        }

        $busesModel = new BusesModel();
        $bus = $busesModel->get(['column' => 'id', 'value' => $data['bus_id']])[0];

        foreach ($passengers['main_clients'] as &$m) {
            $m['birth_date'] = DateConverter::YMDtoDMY($m['birth_date']);
        }

        foreach ($passengers['sub_clients'] as &$ss) {
            foreach ($ss as &$sc) {
                $sc['birth_date'] = DateConverter::YMDtoDMY($sc['birth_date']);
            }
        }

        $data = [
            'title' => 'Список пассажиров',
            'header' => 'Список пассажиров',
            'login' => $_COOKIE['login'],
            'passengers' => $passengers,
            'from_minsk_date' => $tours[0]['from_minsk_date'],
            'arrival_to_minsk' => $tours[0]['arrival_to_minsk'],
            'bus' => $bus
        ];

        $f = fopen(BASE_PATH . "static/passengers/passengers.json", 'w');
        if (!$f) {
            http_response_code(500);
            return;
        }

        fwrite($f, json_encode($data), strlen(json_encode($data)));

        http_response_code(200);
    }

    public function passengers_list(): void
    {
        $this->setView(ClientsView::class);
        $data = json_decode(file_get_contents(BASE_PATH . "static/passengers/passengers.json"), true);
        $this->view->render("passengers/passengers.html.twig", $data);
    }
}