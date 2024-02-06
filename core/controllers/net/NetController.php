<?php

namespace core\controllers\net;

use core\controllers\BaseController;
use core\controllers\rooms\helpers\RoomsHelper;
use core\models\clients\ClientsModel;
use core\models\hotels\HotelsModel;
use core\models\tours\ToursModel;
use core\models\rooms\RoomsModel;
use core\views\net\NetView;

class NetController extends BaseController
{
    private ?RoomsHelper $roomsHelper = null;

    public function __construct()
    {
        $this->roomsHelper = new RoomsHelper();
        $this->setView(NetView::class);
    }

    public function read(): void
    {
        $hotel = $this->getHotel();
        $rooms = $this->getRooms($hotel['id']);
        if (!$hotel || !$rooms) {
            $this->renderEmptyPage('Не удалось найти отель/номера');
            return;
        }

        $current_hotel_id = $this->getCurrentRoomId($rooms) != false ? $this->getCurrentRoomId($rooms) : $rooms[0]['id'];

        $datePeriods = $this->buildDatePeriods($rooms);

        $this->view->render(
            "net/net.html.twig",
            [
                'title' => 'Сетка номеров',
                'header' => 'Сетка номеров',
                'login' => $_COOKIE['login'],
                'hotels' => (new HotelsModel())->get(['column' => 'archived', 'value' => 0]),
                'table' => [
                    'tableHeaders' => $this->buildTableHeaders($rooms),
                    'tableRows' => $this->buildTableRows($rooms)
                ],
                'current_hotel_id' => $hotel['id'],
                'rooms' => $this->removeF($this->roomsHelper->normalizeRooms($rooms)),
                'current_room_id' => $current_hotel_id,
                'last_year_number' => substr(date('y'), 1)
            ]
        );
    }

    private function getHotel(): bool|array
    {
        $hotelsModel = new HotelsModel();
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        $hotel_id = 0;
        if (isset($parsed_url['query'])) {
            parse_str(
                $parsed_url['query'],
                $hotel_id
            );

            $hotel_id = $hotel_id['hotel'];
        }

        $hotel = [];

        if ($hotel_id == 0) {
            $hotel = $hotelsModel->get(['column' => 'archived', 'value' => 0]);
        }

        if ($hotel_id != 0) {
            $hotel = $hotelsModel->get(columnValue: ['column' => 'id', 'value' => $hotel_id]);
        }

        if (count($hotel) > 0) {
            return $hotel[0];
        }

        return false;
    }

    private function getCurrentRoomId(array $rooms): int|false
    {
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        $room_id = false;
        if (isset($parsed_url['query'])) {
            parse_str(
                $parsed_url['query'],
                $room_id_array
            );

            $room_id = $room_id_array['room'] ?? false;
        }

        $found = false;

        if ($room_id) {
            foreach ($rooms as $room) {
                if ($room['id'] == $room_id) {
                    $found = true;
                    break;
                }
            }
        }

        if (!$found) {
            return false;
        }

        return $room_id;
    }

    private function getTours(int $current_room_id): array
    {
        return (new ToursModel())->get([
            'column' => 'room_id',
            'value' => $current_room_id
        ]);
    }

    private function getRooms(int $hotel_id): bool|array
    {
        if ($hotel_id == 0) {
            return false;
        }

        $roomsModel = new RoomsModel();
        $rooms = $roomsModel->get(columnValue: ['column' => 'hotel_id', 'value' => $hotel_id]);

        if (count($rooms) > 0) {
            return $rooms;
        }

        return false;
    }

    private function renderEmptyPage(string $message): void
    {
        $data = [
            'title' => $message,
            'header' => $message,
            'login' => $_COOKIE['login'],
        ];

        $this->view->render("net/net.html.twig", $data);
    }

    private function removeF(array $rooms): array
    {
        foreach ($rooms as &$room) {
            foreach ($room['checkin_checkout_dates'] as &$date) {
                $date = ltrim($date, 'f');
            }
        }

        return $rooms;
    }

    private function buildTableHeaders(array $rooms): array
    {
        $tableHeaders = [];
        $tableHeaders[] = 'Сроки';
        foreach ($rooms as $room) {
            $tableHeaders[] = $room['description'];
        }

        return $tableHeaders;
    }

    private function buildDatePeriods(array $rooms): array
    {
        $rooms = $this->removeF($rooms);
        $roomsHelper = new RoomsHelper();
        foreach ($rooms as &$room) {
            $room = $roomsHelper->normalizeRoom($room);
        }
        $datePeriods = [];

        foreach ($rooms as $room) {
            $a = 5;
        }

        return $datePeriods;
    }

    private function buildTableRows(array $rooms): array
    {
        $tableRows = [];

        foreach ($rooms as $room) {
            $tableRows[] = [
                'date' => $this->buildTableRowDate($room),
                'status' => $this->buildTableRowStatuses($room)
            ];
        }

        return $tableRows();
    }

    private function buildTableRowDate(array $room): string
    {
        return '';
    }

    private function buildTableRowStatuses(array $room): array
    {
        return [];
    }
}
