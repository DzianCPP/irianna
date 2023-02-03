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

    public function new (): void
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

        if ($hotelId) {
            $rooms = $this->model->get(columnValue:
                [
                    'column' => 'hotel_id',
                    'value' => $hotelId
                ]);
        } else {
            $rooms = $this->model->get();
        }

        if ($hotelId) {
            $hotel = $hotelsModel->get(columnValue:
                [
                    'column' => 'id',
                    'value' => $hotelId
                ])[0];
        } else {
            $hotel = $hotelsModel->get()[0];
        }

        $rooms = $roomsHelper->normalizeRooms($rooms);

        $toursModel = new ToursModel();
        $tours_set = [];

        foreach ($rooms as $room) {
            $tours_set[] = $toursModel->get(columnValue: ['column' => 'room_id', 'value' => $room['id']]);
        }

        foreach ($rooms as &$room) {
            foreach ($room['checkin_checkout_dates'] as &$date) {
                foreach ($tours_set as $tours) {
                    foreach ($tours as $tour) {
                        if (($d = 'f' . $tour['checkout_date']) == $date) {
                            $date = str_replace('f', 'b', $date);
                            for($i = 0; $i <= count($room['checkin_checkout_dates']); $i++) {
                                if ($room['checkin_checkout_dates'][$i] == $date) {
                                    $room['checkin_checkout_dates'][$i-1] = str_replace('f', 'b', $room['checkin_checkout_dates'][$i-1]);
                                }
                            }
                        }
                    }
                }
            }
        }

        $data = [
            'title' => 'Номера',
            'hotel' => $hotel,
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

    public function update(int $id = 0): void
    {
        $room = json_decode(file_get_contents("php://input"), true);
        $this->setModel(RoomsModel::class);
        $this->model->update($room);
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
        ;
    }
}