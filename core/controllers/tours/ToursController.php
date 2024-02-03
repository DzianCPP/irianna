<?php

namespace core\controllers\tours;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\controllers\rooms\helpers\RoomsHelper;
use core\models\contracts\ContractsModel;
use core\models\stamps\StampsModel;
use core\services\Paginator;
use core\services\ToursDateGetter;
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
use core\services\ContractMaker;
use Error;

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
        $roomsHelper = new RoomsHelper();
        $this->setModel(ToursModel::class);

        $rooms = $rooms->get();

        foreach ($rooms as &$room) {
            $room = $roomsHelper->normalizeRoom($room);
        }

        foreach ($rooms as &$room) {

            $checkin_dates = [];
            $checkout_dates = [];
            for ($i = 0; $i < count($room['checkin_checkout_dates']); $i++) {
                if ($i % 2 > 0) {
                    $checkout_dates[] = substr($room['checkin_checkout_dates'][$i], 1);
                } else {
                    $checkin_dates[] = substr($room['checkin_checkout_dates'][$i], 1);
                }
            }

            $room['checkin_dates'] = $checkin_dates;
            $room['checkout_dates'] = $checkout_dates;
            unset($room['checkin_checkout_dates']);
        }

        $free_dates = ['in_dates' => [], 'out_dates' => []];

        foreach ($rooms as &$room) {
            $tours = $this->model->get(['column' => 'room_id', 'value' => $room['id']]);
            $busy_checkin_dates = [];
            $busy_checkout_dates = [];
            foreach ($tours as $tour) {
                if (array_search($tour['checkin_date'], $room['checkin_dates']) !== false) {
                    $busy_checkin_dates[] = $tour['checkin_date'];
                }

                if (array_search($tour['checkout_date'], $room['checkout_dates']) !== false) {
                    $busy_checkout_dates[] = $tour['checkout_date'];
                }
            }

            $room['busy_checkin_dates'] = $busy_checkin_dates;
            $room['busy_checkout_dates'] = $busy_checkout_dates;

            $free_checkin_dates = [];
            $free_checkout_dates = [];

            foreach ($room['checkin_dates'] as $in_date) {
                if (array_search($in_date, $room['busy_checkin_dates']) === false) {
                    $free_checkin_dates[] = $in_date;
                    $free_dates['in_dates'][] = $in_date;
                }
            }

            $room['checkin_dates'] = $free_checkin_dates;

            foreach ($room['checkout_dates'] as $out_date) {
                if (array_search($out_date, $room['busy_checkout_dates']) === false) {
                    $free_checkout_dates[] = $out_date;
                    $free_dates['out_dates'][] = $out_date;
                }
            }

            $room['checkout_dates'] = $free_checkout_dates;
        }

        $data = [
            'title' => 'Добавить тур',
            'header' => 'Добавить тур',
            'login' => $_COOKIE['login'],
            'managers' => $managers->get(),
            'countries' => $countries->get(),
            'resorts' => json_encode($resorts->get()),
            'hotels' => json_encode($hotels->get()),
            'buses' => $buses->get(),
            'rooms' => json_encode($rooms),
            'currencies' => json_decode(file_get_contents(BASE_PATH . "config/currencies.json"), true),
            'free_dates' => json_encode($free_dates)
        ];

        $this->setView(ToursView::class);
        $this->view->render("tours/new.html.twig", $data);
    }
    public function edit(): void
    {
        $this->setModel(ToursModel::class);
        $this->setView(ToursView::class);
        $tour = $this->model->get(columnValue: ['column' => $this->model->getTableName() . '.id', 'value' => IdGetter::getId()])[0];
        $managers = new ManagersModel();
        $countries = new CountriesModel();
        $resorts = new ResortsModel();
        $hotels = new HotelsModel();
        $rooms = new RoomsModel();
        $buses = new BusesModel();
        $client = new ClientsModel();
        $roomsHelper = new RoomsHelper();
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

        $rooms = $rooms->get();

        foreach ($rooms as &$room) {
            $room = $roomsHelper->normalizeRoom($room);
        }

        foreach ($rooms as &$room) {

            $checkin_dates = [];
            $checkout_dates = [];
            for ($i = 0; $i < count($room['checkin_checkout_dates']); $i++) {
                if ($i % 2 > 0) {
                    $checkout_dates[] = substr($room['checkin_checkout_dates'][$i], 1);
                } else {
                    $checkin_dates[] = substr($room['checkin_checkout_dates'][$i], 1);
                }
            }

            $room['checkin_dates'] = $checkin_dates;
            $room['checkout_dates'] = $checkout_dates;
            unset($room['checkin_checkout_dates']);
        }

        $free_dates = ['in_dates' => [], 'out_dates' => []];

        foreach ($rooms as &$room) {
            $tours = $this->model->get(['column' => 'room_id', 'value' => $room['id']]);
            $busy_checkin_dates = [];
            $busy_checkout_dates = [];

            foreach ($tours as $t) {
                if (array_search($t['checkin_date'], $room['checkin_dates']) !== false) {
                    $busy_checkin_dates[] = $t['checkin_date'];
                }

                if (array_search($t['checkout_date'], $room['checkout_dates']) !== false) {
                    $busy_checkout_dates[] = $t['checkout_date'];
                }
            }

            $room['busy_checkin_dates'] = $busy_checkin_dates;
            $room['busy_checkout_dates'] = $busy_checkout_dates;

            $free_checkin_dates = [];
            $free_checkout_dates = [];

            foreach ($room['checkin_dates'] as $in_date) {
                if (array_search($in_date, $room['busy_checkin_dates']) === false) {
                    $free_checkin_dates[] = $in_date;
                    $free_dates['in_dates'][] = $in_date;
                }
            }

            $room['checkin_dates'] = $free_checkin_dates;

            foreach ($room['checkout_dates'] as $out_date) {
                if (array_search($out_date, $room['busy_checkout_dates']) === false) {
                    $free_checkout_dates[] = $out_date;
                    $free_dates['out_dates'][] = $out_date;
                }
            }

            $room['checkout_dates'] = $free_checkout_dates;
        }

        $data = [
            'tour' => $tour,
            'managers' => $managers->get(),
            'countries' => $countries->get(),
            'resorts' => json_encode($resorts->get()),
            'hotels' => json_encode($hotels->get()),
            'rooms' => json_encode($rooms),
            'resorts_array' => $resorts->get(),
            'hotels_array' => $hotels->get(),
            'rooms_array' => $rooms,
            'buses' => $buses->get(),
            'client' => $client,
            'sub_clients' => $sub_clients,
            'currencies' => json_decode(file_get_contents(BASE_PATH . "config/currencies.json"), true),
            'title' => 'Изменить тур',
            'header' => 'Изменить тур',
            'login' => $_COOKIE['login'],
            'free_dates' => json_encode($free_dates)
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

        http_response_code(200);
    }

    public function read(int $id = 0): void
    {
        $this->setModel(ToursModel::class);
        $this->setView(ToursView::class);
        $tours = array_reverse($this->model->get(
                columnValue: [
                    'column' => 'archived',
                    'value' => 0
                ]
            )
        );

        $clients = new ClientsModel();
        $sub_clients = $clients->getSubClients();
        $clients = $clients->get();
        $hotels = new HotelsModel();
        $rooms = new RoomsModel();
        $resorts = new ResortsModel();
        $managers = new ManagersModel();
        $buses = new BusesModel();

        $page = Paginator::getPage();
        $pages = (int) ceil(count($tours) / parent::PER_PAGE);

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

    public function search(): void
    {
        $this->setModel(ToursModel::class);
        $this->setView(ToursView::class);
        $tours = $this->model->search();
        $clients = new ClientsModel();
        $sub_clients = $clients->getSubClients();
        $clients = $clients->get();
        $hotels = new HotelsModel();
        $rooms = new RoomsModel();
        $resorts = new ResortsModel();
        $managers = new ManagersModel();
        $buses = new BusesModel();

        $params = json_decode(file_get_contents(BASE_PATH . "static/search/request.json"), true);

        $page = Paginator::getPage();
        $pages = (int) ceil(count($tours) / parent::PER_PAGE);

        if ($page) {
            Paginator::limitRange($tours, self::PER_PAGE, $page);
        } else {
            Paginator::limitRange($tours, self::PER_PAGE);
        }

        $data = [
            'message' => 'No such tours',
            'header' => 'Нет туров',
            'title' => 'Нет туров',
            'login' => $_COOKIE['login'],
        ];


        if ($tours != []) {
            $data = [
                'tours' => $tours,
                'entity' => 'tours/search',
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
                'pages' => $pages,
                'message' => 'Found tours',
                'bus_id' => isset($params['bus_id']) ? $params['bus_id'] : 0,
                'hotel_id' => isset($params['hotel_id']) ? $params['hotel_id'] : 0,
                'from_minsk_date' => isset($params['from_minsk_date']) ? $params['from_minsk_date'] : 0,
                'to_minsk_date' => isset($params['to_minsk_date']) ? $params['to_minsk_date'] : 0,
                'name' => isset($params['name']) ? $params['name'] : 0
            ];
        }

        $this->setView(ToursView::class);
        $this->view->render("tours/search.html.twig", $data);
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

        $tours = [];

        foreach ($ids as $id) {
            $tour = $this->model->get(['column' => 'id', 'value' => $id]);
            if (count($tour) < 1) {
                continue;
            }

            $tours[] = $tour[0];
        }

        $clientsModel = new ClientsModel();

        foreach ($tours as $tour) {
            if (!$clientsModel->deleteSubClients((int) $tour['owner_id'])) {
                http_response_code(500);
                return;
            }

            if (!$clientsModel->delete(columnValues: ['column' =>  'id', 'values' => [$tour['owner_id']]])) {
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

    public function getContractHTML(): void
    {
        if (!file_exists(BASE_PATH . 'templates/components/contract.html.twig')) {
            http_response_code(500);

            return;
        }

        $contractHtmlTwig = file_get_contents(BASE_PATH . 'templates/components/contract.html.twig');
        if (!$contractHtmlTwig) {
            http_response_code(500);

            return;
        }

        $contractHtml = trim($contractHtmlTwig, '{% block contract %}');
        $contractHtml = rtrim($contractHtml, '{% endblock %}');

        echo $contractHtml;
    }

    public function printContract(): void
    {
        $this->setModel(ToursModel::class);
        $toursModel = new ToursModel();
        $id = IdGetter::getId();
        $tour = [];

        if ($id) {
            $tour = $toursModel->get(['column' => 'tours_table.id', 'value' => $id])[0];
        } else {
            $tour = $this->model->getLastTour();
        }

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
        $age_of_children = $tour['ages'] ?? $tour['ages'] || '--';
        $stamp = (new StampsModel())->get([
            'column' => 'manager_id',
            'value' => $manager['id']
        ])[0];

        $contractData = [
            'resort_name' => $resort['name'],
            'hotel_name' => $hotel['name'],
            'day' => ToursDateGetter::getTourDay($tour),
            'month' => ToursDateGetter::getTourMonth($tour),
            'year' => ToursDateGetter::getTourYear($tour),
            'from_minsk_date' => $tour['from_minsk_date'],
            'arrival_to_minsk' => $tour['arrival_to_minsk'],
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
            'total_travel_cost_curr_1' => explode(' ', $tour['total_travel_cost_byn'])[0],
            'currency_1' => explode(' ', $tour['total_travel_cost_byn'])[1],
            'currency' => explode(' ', $tour['total_travel_cost_currency'])[1],
            'country' => $countriesModel->get(['column' => 'id', 'value' => $resort['country_id']])[0]['name'],
            'only_transit' => $tour['is_only_transit'],
            'stamp' => $stamp
        ];

        $contract = ContractMaker::prepareContract($contract, $contractData);
        $contract = '{% block contract %}' . $contract . '{% endblock %}';
        $fileName = 'contract.html.twig';
        $contractFileName = 'templates/components/' . $fileName;

        touch(BASE_PATH . $contractFileName);
        $fc = fopen(BASE_PATH . $contractFileName, 'w');
        fwrite($fc, $contract, strlen($contract));
        fclose($fc);

        $data = [
            'title' => 'Печать договора',
            'header' => 'Печать договора',
            'login' => $_COOKIE['login']
        ];

        $this->setView(ToursView::class);
        $this->view->render("tours/print.html.twig", $data);
    }

    public function printAttachmentTwo(): void
    {
        $this->setModel(ToursModel::class);
        $id = IdGetter::getId();
        if ($id) {
            $tour = $this->model->get(columnValue: ['column' => $this->model->getTableName() . '.id', 'value' => $id])[0];
        } else {
            $tour = $this->model->getLastTour();
        }
        $clientsModel = new ClientsModel();
        $client = $clientsModel->get(columnValue: ['column' => 'id', 'value' => $tour['owner_id']])[0];

        $contractsModel = new ContractsModel();

        $resortsModel = new ResortsModel();
        $resort = $resortsModel->get(['column' => 'id', 'value' => $tour['resort_id']])[0];

        $hotelsModel = new HotelsModel();
        $hotel = $hotelsModel->get(['column' => 'id', 'value' => $tour['hotel_id']])[0];

        $busesModel = new BusesModel();
        $bus = $busesModel->get(['column' => 'id', 'value' => $tour['bus_id']])[0];

        $roomsModel = new RoomsModel();
        $room = $roomsModel->get(['column' => 'id', 'value' => $tour['room_id']])[0];

        $attachment2 = $contractsModel->get(columnValue: ['column' => 'label', 'value' => 'attachment-2'])[0];
        $attachment2['html'] = htmlspecialchars_decode($attachment2['html'], ENT_QUOTES);
        $attachment2 = $attachment2['html'];

        $fileName = 'attachment2.html.twig';
        $fullFileName = 'templates/components/' . $fileName;

        $fp = fopen(BASE_PATH . $fullFileName, 'w');
        fwrite($fp, $attachment2, strlen($attachment2));
        fclose($fp);
        $documentData = [
            'resort_name' => $resort['name'],
            'hotel_name' => $hotel['name'],
            'from_minsk_date' => $tour['from_minsk_date'],
            'arrival_to_minsk' => $tour['arrival_to_minsk'],
            'to_minsk_date' => $tour['to_minsk_date'],
            'hotel_area' => $hotel['area'],
            'hotel_beach' => $hotel['beach'],
            'hotel_housing' => $hotel['housing'],
            'room_description' => $room['description'],
            'room_water' => $hotel['water'],
            'room_food' => $room['food'],
            'room_comforts' => $room['comforts'],
            'room_features' => $hotel['features'],
            'bus_route' => $bus['route'],
            'hotel_address' => $hotel['address'],
            'client_name' => $client['name'],
            'main_phone' => $client['main_phone'],
            'second_phone' => $client['second_phone'],
            '_note' => 'дополнительные услуги оплачиваются туристами по месту отдыха (питание, экскурсии и т. д.). При открытых окнах в пансионатах и гостиницах возможно попадание насекомых в номера. В случае аварии на подстанциях возможны перебои с водой и электричеством. Время заселения/выселения на базы отдыха может быть увеличено из-за большой транспортной загруженности курорта. Расселением туристов по номерам занимается администрация. Время заселения (выселения) зависит от времени прибытия (убытия) автобуса и регламентируется руководителем тур. группы и администрацией базы отдыха. Туристы, прибывшие на автобусе, уведомляются о времени ожидания перед заселением (2-3 часа) для уборки номера. Туристы, закончившие свой отдых, должны освободить номера по требованию администрации к моменту приезда автобуса. Проверьте наличие паспорта перед выездом на отдых.'
        ];

        $attachment2 = ContractMaker::prepareAttachment2($attachment2, $documentData);
        $attachment2 = '{% block attachment2 %}' . $attachment2 . '{% endblock %}';
        $fileName = 'attachment2.html.twig';
        $fullFileName = 'templates/components/' . $fileName;

        $fp = fopen(BASE_PATH . $fullFileName, 'w');
        fwrite($fp, $attachment2, strlen($attachment2));
        fclose($fp);

        $data = [
            'title' => 'Печать приложения 2',
            'header' => 'Печать приложения 2',
            'login' => $_COOKIE['login']
        ];

        $this->setView(ToursView::class);
        $this->view->render("tours/printAttachment2.html.twig", $data);
    }

    public function count(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $bus_id = (int) $data['bus_id'];
        $from_minsk_date = $data['from_minsk_date'];

        $this->setModel(ToursModel::class);
        $count = $this->model->count(columnsValues: [
            'columns' => ['bus_id', 'from_minsk_date'],
            'values' => [$bus_id, $from_minsk_date]
        ]);

        echo json_encode($count);
    }

    public function countPlacesBack(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $bus_id = (int) $data['bus_id'];
        $arrival_to_minsk = $data['arrival_to_minsk'];

        $this->setModel(ToursModel::class);
        $count = $this->model->count(columnsValues: [
            'columns' => ['bus_id', 'arrival_to_minsk'],
            'values' => [$bus_id, $arrival_to_minsk]
        ]);

        echo json_encode($count);
    }

    public function printVoucher(): void
    {
        $this->setModel(ToursModel::class);
        $id = IdGetter::getId();
        if ($id) {
            $tour = $this->model->get(columnValue: ['column' => $this->model->getTableName() . '.id', 'value' => $id])[0];
        } else {
            $tour = $this->model->getLastTour();
        }

        $clientsModel = new ClientsModel();
        $client = $clientsModel->get(columnValue: ['column' => 'id', 'value' => $tour['owner_id']])[0];

        $sub_clients = $clientsModel->getSubClients(columnValue: ['column' => 'main_client_id', 'value' => $client['id']]);

        if (count($sub_clients) < 1) {
            $sub_clients = "----";
        } else if (count($sub_clients) >= 1) {
            $str = "";
            foreach ($sub_clients as &$s) {
                $str .= $s['name'] . ', ' . $s['passport'] . ', ' . $s['birth_date'] . '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }
            $str = rtrim($str, "<br>");
            $sub_clients = $str;
        } else {
            $str = $sub_clients['name'] . ', ' . $sub_clients['passport'] . ', ' . $sub_clients['birth_date'];
            $sub_clients = $str;
        }

        $contractsModel = new ContractsModel();
        $busesModel = new BusesModel();
        $bus = $busesModel->get(['column' => 'id', 'value' => $tour['bus_id']])[0];

        $roomsModel = new RoomsModel();
        $room = $roomsModel->get(['column' => 'id', 'value' => $tour['room_id']])[0];

        $hotelsModel = new HotelsModel();
        $hotel = $hotelsModel->get(['column' => 'id', 'value' => $tour['hotel_id']])[0];

        $resortsModel = new ResortsModel();
        $resort = $resortsModel->get(['column' => 'id', 'value' => $tour['resort_id']])[0];


        $voucher = $contractsModel->get(columnValue: ['column' => 'label', 'value' => 'voucher'])[0];
        $voucher['html'] = htmlspecialchars_decode($voucher['html'], ENT_QUOTES);
        $voucher = $voucher['html'];

        $fileName = 'voucher.html.twig';
        $fullFileName = 'templates/components/' . $fileName;

        $fp = fopen(BASE_PATH . $fullFileName, 'w');
        fwrite($fp, $voucher, strlen($voucher));
        fclose($fp);
        $documentData = [
            'client_name' => $client['name'],
            'client_birthdate' => $client['birth_date'],
            'client_passport' => $client['passport'],
            'client_main_phone' => $client['main_phone'],
            'client_second_phone' => $client['second_phone'],
            'client_address' => $client['address'],
            'bus_route' => $bus['route'],
            'from_minsk_date' => $tour['from_minsk_date'],
            'arrival_to_minsk' => $tour['arrival_to_minsk'],
            'service_cost_in_BYN' => $tour['total_travel_service_byn'],
            'tour_price_in_curr_1' => explode(' ', $tour['total_travel_cost_currency'])[0],
            'total_travel_cost_curr_2' => explode(' ', $tour['total_travel_cost_byn'])[0],
            'currency_1' => explode(' ', $tour['total_travel_cost_byn'])[1],
            'currency_2' => explode(' ', $tour['total_travel_cost_currency'])[1],
            'room_description' => $room['description'],
            'room_food' => $room['food'],
            'room_comforts' => $room['comforts'],
            'transfer_direction' => 'Туда-Обратно',
            'hotel_name' => $hotel['name'],
            'resort_name' => $resort['name'],
            'transfer_type' => $tour['is_only_transit'],
            'today_date' => date('d.m.Y'),
            'sub_clients' => $sub_clients
        ];

        $voucher = ContractMaker::prepareVoucher($voucher, $documentData);
        $voucher = '{% block voucher %}' . $voucher . '{% endblock %}';
        $fileName = 'voucher.html.twig';
        $fullFileName = 'templates/components/' . $fileName;

        $fp = fopen(BASE_PATH . $fullFileName, 'w');
        fwrite($fp, $voucher, strlen($voucher));
        fclose($fp);

        $data = [
            'title' => 'Печать путевки',
            'header' => 'Печать путевки',
            'login' => $_COOKIE['login']
        ];

        $this->setView(ToursView::class);
        $this->view->render("tours/printVoucher.html.twig", $data);
    }

    public function request(): void
    {
        $request = json_encode(json_decode(file_get_contents("php://input"), true));
        $f = fopen(BASE_PATH . 'static/search/request.json', 'w');
        if (!$f) {
            http_response_code(500);
        }

        fwrite($f, $request, strlen($request));
        fclose($f);

        http_response_code(200);
    }

    public function last(): void
    {
        $this->setModel(ToursModel::class);
        $last = $this->model->getLastTour();
        $last_id = $last['id'];
        echo json_encode($last_id);
    }
}
