<?php

namespace core\controllers\rooms;

use core\controllers\ControllerInterface;
use core\controllers\BaseController;
use core\models\hotels\HotelsModel;
use core\models\rooms\RoomsModel;
use core\models\tours\ToursModel;
use core\views\rooms\RoomsView;
use core\services\IdGetter;
use core\controllers\rooms\helpers\RoomsHelper;
use DateTime;
use core\models\entries\EntryModel;

class RoomsController extends BaseController implements ControllerInterface
{
    public function pickHotel(): void
    {
        $hotelsModel = new HotelsModel();
        $this->setView(RoomsView::class);

        $data = [
            'hotels' => $hotelsModel->get(),
            'header' => 'Выберите гостиницу',
            'title' => 'Выберите гостиницу',
            'login' => $_COOKIE['login']
        ];

        $this->view->render("rooms/pickHotel.html.twig", $data);
    }

    public function new(): void
    {
        $hotel_id = (int) filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_NUMBER_INT);
        $hotelsModel = new HotelsModel();
        $this->setView(RoomsView::class);
        $rooms = new RoomsModel();

        $data = [
            'hotel' => $hotelsModel->get(columnValue: ['column' => 'id', 'value' => $hotel_id])[0],
            'title' => 'Номера',
            'header' => 'Добавить номера',
            'comforts' => $rooms->getComforts(),
            'food' => $rooms->getFood(),
            'login' => $_COOKIE['login']
        ];

        $this->view->render("rooms/new.html.twig", $data);
    }
    public function edit(): void
    {
        $id = IdGetter::getId();
        $this->setModel(RoomsModel::class);
        $room = $this->model->get(columnValue: ['column' => 'id', 'value' => $id])[0];
        $this->setView(RoomsView::class);

        $roomsHelper = new RoomsHelper();
        $room = $roomsHelper->normalizeRoom($room);

        $room['entries'] = (new EntryModel())->getByRoomId($room['id']);

        $this->convertEntries($room);

        $data = [
            'title' => 'Изменить номер',
            'header' => 'Изменить номер',
            'comforts' => $this->model->getComforts(),
            'food' => $this->model->getFood(),
            'login' => $_COOKIE['login'],
            'room' => $room
        ];

        $this->view->render("rooms/edit.html.twig", $data);
    }

    public function create(): void
    {
        $this->setModel(RoomsModel::class);
        $this->model->create();
    }

    public function read(int $id = 0): void
    {
        $hotelsModel = new HotelsModel();
        $this->setModel(RoomsModel::class);
        $roomsHelper = new RoomsHelper();
        $hotelId = $roomsHelper->getHotelId();

        if (!$hotelId) {
            $hotels = $hotelsModel->get();

            $hotelId = $hotels[0]['id'];
            $hotel = $hotels[0];
            unset($hotels);
        }

        $rooms = [];
        $hotel = $hotel ?? $hotelsModel->get(['column' => 'id', 'value' => $hotelId])[0];

        if ($hotelId) {
            $rooms = $this->model->getRoomsByHotelId($hotelId);
        }

        $entryModel = new EntryModel();
        foreach ($rooms as &$room) {
            $room['entries'] = $entryModel->getByRoomId($room['id']);
        }

        foreach ($rooms as &$room) {
            $room['comforts'] = explode(',', $room['comforts']);
            $room['food'] = explode(',', $room['food']);
            $this->convertEntries($room);
        }

        $data = [
            'title' => 'Номера',
            'hotel' => $hotel['archived'] === 0 ? $hotel : false,
            'hotels' => $hotelsModel->get(),
            'rooms' => $rooms,
            'header' => 'Номера',
            'login' => $_COOKIE['login']
        ];

        $this->setView(RoomsView::class);
        $this->view->render("rooms/rooms.html.twig", $data);
    }

    public function readOne(): void
    {
        $id = (int) IdGetter::getId();
        $this->setModel(RoomsModel::class);
        $room = $this->model->get(columnValue: ['column' => 'id', 'value' => $id])[0];
        $room = json_encode($room);
        echo $room;

    }

    public function free(): void
    {
        $this->setModel(RoomsModel::class);
        $hotel_id = IdGetter::getId();
        $rooms = $this->model->get(['column' => 'hotel_id', 'value' => $hotel_id]);
        $free_dates = ['in_dates' => [], 'out_dates' => []];
        $toursModel = new ToursModel();
        $roomsHelper = new RoomsHelper();

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

        foreach ($rooms as &$room) {
            $tours = $toursModel->get(['column' => 'room_id', 'value' => $room['id']]);
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

        echo json_encode($free_dates);
    }

    public function update(int $id = 0): void
    {
        $room = json_decode(file_get_contents("php://input"), true);
        $this->setModel(RoomsModel::class);
        $this->model->update($room);
        $entryModel = new EntryModel();
        $entryModel->create($room);
    }

    public function delete(int $id = 0): void
    {
        $ids = json_decode(file_get_contents("php://input"), true);
        if (count($ids) < 1) {
            return;
        }

        $this->setModel(RoomsModel::class);
        if (
            !$this->model->delete([
                'column' => 'id',
                'values' => $ids
            ])
        ) {
            http_response_code(500);
        }
    }

    public function dates(): void
    {
        $this->setModel(RoomsModel::class);
        $roomsHelper = new RoomsHelper();
        $rooms = $this->model->get(columnValue: [
            'column' => 'hotel_id',
            'value' => IdGetter::getId()
        ]);

        if (!$rooms) {
            http_response_code(500);
            return;
        }

        $rooms = $roomsHelper->normalizeRooms($rooms);
        $this->ltrimDates($rooms);
        $total_dates = $this->prepareDates($rooms);

        echo json_encode($total_dates);
        http_response_code(200);
        return;
    }

    private function ltrimDates(array &$rooms): void
    {
        foreach ($rooms as &$room) {
            foreach ($room['checkin_checkout_dates'] as &$date) {
                $date = ltrim($date, 'f');
            }
        }

        return;
    }

    private function prepareDates(array &$rooms): array
    {
        $total_dates = [
            'checkin_dates' => $this->prepareCheckinDates($rooms),
            'checkout_dates' => $this->prepareCheckoutDates($rooms)
        ];

        return $total_dates;
    }

    private function prepareCheckinDates(array &$rooms): array
    {
        $checkin_dates = [];
        foreach ($rooms as &$room) {
            $this->getCheckinDates($checkin_dates, $room['checkin_checkout_dates']);
        }

        return $checkin_dates;
    }

    private function prepareCheckoutDates(array &$rooms): array
    {
        $checkout_dates = [];
        foreach ($rooms as &$room) {
            $this->getCheckoutDates($checkout_dates, $room['checkin_checkout_dates']);
        }

        return $checkout_dates;
    }


    private function getCheckinDates(array &$checkin_dates, array &$checkin_checkout_dates): void
    {
        for ($i = 0; $i < count($checkin_checkout_dates); $i += 2) {
            if (!in_array($checkin_checkout_dates[$i], $checkin_dates)) {
                $checkin_dates[] = $checkin_checkout_dates[$i];
            }
        }

        $checkin_dates = $this->sortDates($checkin_dates);
    }

    private function getCheckoutDates(array &$checkout_dates, array &$checkin_checkout_dates): void
    {
        for ($i = 1; $i < count($checkin_checkout_dates); $i += 2) {
            if (!in_array($checkin_checkout_dates[$i], $checkout_dates)) {
                $checkout_dates[] = $checkin_checkout_dates[$i];
            }
        }

        $checkout_dates = $this->sortDates($checkout_dates);
    }

    private function sortDates(array $dates): array
    {
        $sorted_dates = [];
        foreach ($dates as &$date) {
            $date = DateTime::createFromFormat("d.m.Y", $date);
            $date = $date->getTimestamp();
            $sorted_dates[] = $date;
        }

        sort($sorted_dates);

        foreach($sorted_dates as &$date) {
            $date = gmdate("d.m.Y", $date);
        }

        return $sorted_dates;
    }

    private function convertEntries(array &$room): void
    {
        foreach ($room['entries'] as &$entry) {
            $entry['dateFrom'] = $this->convertDate($entry['dateFrom']);
            $entry['dateTo'] = $this->convertDate($entry['dateTo']);
        }
    }

    private function convertDate(string $date): string
    {
        [$year, $month, $day] = explode('-', $date);

        return $day . '.' . $month . '.' . $year;
    }
}