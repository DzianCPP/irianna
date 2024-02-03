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

        $this->view->render(
            "net/net.html.twig",
            [
                'title' => 'Сетка номеров',
                'header' => 'Сетка номеров',
                'login' => $_COOKIE['login'],
                'hotels' => (new HotelsModel())->get(['column' => 'archived', 'value' => 0]),
                'table' => [
                    'dates' => ($dates = $this->buildTableDates($rooms)),
                    'tours' => $this->buildTableRows($current_hotel_id, $dates)
                ],
                'current_hotel_id' => $hotel['id'],
                'rooms' => $this->removeF($this->roomsHelper->normalizeRooms($rooms)),
                'current_room_id' => $current_hotel_id,
                'last_year_number' => substr(date('y'), 1)
            ]
        );
    }

    private function buildTableDates(array $rooms): array
    {
        $room = (new RoomsModel)->get(
            columnValue: [
                'column' => 'id',
                'value' => $this->getCurrentRoomId($rooms) != false ? $this->getCurrentRoomId($rooms) : $rooms[0]['id']
            ]
        );

        $room = $this->removeF($this->roomsHelper->normalizeRooms($room));

        $dates = [];

        for ($i = 0; $i < count($room[0]['checkin_checkout_dates']); $i++) {
            $dates[] = [
                'from' => $room[0]['checkin_checkout_dates'][$i],
                'to' => $room[0]['checkin_checkout_dates'][++$i]
            ];
        }

        return $dates;
    }

    private function buildTableRows(int $current_room_id, array $dates): array
    {
        $tours = $this->getTours($current_room_id);
        $tableRows = [];

        foreach ($dates as $date) {
            $busy = $owner = $guests_count = false;

            foreach ($tours as &$tour) {
                if ($date['from'] == $tour['checkin_date'] && $date['to'] == $tour['checkout_date']) {
                    $busy = true;
                    $owner = (new ClientsModel())->get(columnValue: [
                        'column' => 'id',
                        'value' => $tour['owner_id']
                    ])[0];

                    $guests = (new ClientsModel())->getSubClients(
                        columnValue: [
                            'column' => 'main_client_id',
                            'value' => $owner['id']
                        ]
                    );

                    $guests_count = count($guests) + 1;
                }
            }

            $tableRows[] = [
                'busy' => $busy,
                'owner' => $owner,
                'guests_count' => $guests_count
            ];
        }

        return $tableRows;
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
}
