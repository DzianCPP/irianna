<?php

namespace core\controllers\rooms;

use core\controllers\ControllerInterface;
use core\controllers\BaseController;
use core\models\hotels\HotelsModel;
use core\models\rooms\RoomsModel;
use core\views\rooms\RoomsView;

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
        $hotel_id = (int)filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_NUMBER_INT);
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
        $page = $this->getPage();

        $rooms = $this->model->get();
        foreach ($rooms as &$room) {
            $room['checkin_checkout_dates'] = json_decode($room['checkin_checkout_dates'], true);
        }

        foreach ($rooms as &$room) {
            $middle = count($room['checkin_checkout_dates']) / 2;
            $room['checkins'] = array_values(array_slice($room['checkin_checkout_dates'], 0, $middle, true));
            $room['checkouts'] = array_values(array_slice($room['checkin_checkout_dates'], $middle));
            for ($i = 0; $i < count($room['checkins']); $i++) {
                $room['dates'][$i] = [
                    'checkin' => $room['checkins'][$i],
                    'checkout' => $room['checkouts'][$i]
                ];
            }
        }

        $pages = (int)ceil(count($rooms) / parent::PER_PAGE);
        if ($page) {
            $this->limitRange($rooms, $page);
        } else {
            $this->limitRange($rooms);
        }

        $data = [
            'title' => 'Номера',
            'hotels' => $hotelsModel->get(),
            'rooms' => $rooms,
            'header' => 'Номера',
            'currentPage' => $page,
            'pages' => $pages,
            'login' => $_COOKIE['login']
        ];

        $this->setView(RoomsView::class);
        $this->view->render("rooms/rooms.html.twig", $data);
    }
    public function update(int $id = 0): void
    {
    }
    public function delete(int $id = 0): void
    {
    }
}
