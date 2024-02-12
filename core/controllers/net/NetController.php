<?php

namespace core\controllers\net;

use core\controllers\BaseController;
use core\models\clients\ClientsModel;
use core\models\hotels\HotelsModel;
use core\models\rooms\RoomsModel;
use core\models\tours\ToursModel;
use core\views\net\NetView;

class NetController extends BaseController
{
    public function __construct()
    {
        $this->setView(NetView::class);
    }

    public function read(): void
    {
        $hotel = $this->getHotel();
        $dates = $this->getDates($hotel);
        $rooms = $this->getRooms($hotel, $dates);

        if (!$hotel || !$rooms || !$dates) {
            $this->renderEmptyPage('Не удалось найти отель/номера');
            return;
        }

        $this->normalizeRooms($rooms);

        $this->view->render(
            "net/net.html.twig",
            [
                'title' => 'Сетка номеров',
                'header' => 'Сетка номеров',
                'login' => $_COOKIE['login'],
                'hotels' => (new HotelsModel())->get(
                    [
                        'column' => 'archived',
                        'value' => 0
                    ]
                ),
                'dates' => $dates,
                'rooms' => $rooms,
                'rows' => $this->buildRows($dates, $rooms),
                'current_hotel_id' => $hotel['id'],
                'last_year_number' => substr(date('y'), 1)
            ]
        );
    }

    private function getHotel(): array|false
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

    private function getDates(array $hotel): array|false
    {
        if (!$hotel) {
            return false;
        }

        $rawDates = (new RoomsModel())->getDatesByHotelId($hotel['id']);

        return $this->normalizeRoomDates($rawDates);
    }

    private function getRooms(array $hotel, array $dates): array|false
    {
        if (
            !$hotel
            || !$hotel['id']
            || !$dates
        ) {
            return false;
        }

        $rooms = (new RoomsModel())->get(
            columnValue: [
                'column' => 'hotel_id',
                'value' => $hotel['id']
            ]
        );

        if (!$rooms) {
            return false;
        }

        return $rooms;
    }

    private function normalizeRooms(array &$rooms): void
    {
        foreach ($rooms as &$room) {
            $room['dates'] = $this->normalizeRoomDates([
                [$room['checkin_checkout_dates']]
            ]);
        }
    }

    private function normalizeRoomDates(array $rawDates): array|false
    {
        foreach ($rawDates as &$rawDatesList) {
            $rawDatesList[0] = explode(', ', str_replace('f', '', $rawDatesList[0]));
        }

        unset($rawDatesList);

        $checkinDates = $checkoutDates = [];

        foreach ($rawDates as &$rawDatesList) {
            $checkinDates = array_merge(
                $checkinDates,
                array_slice(
                    array: $rawDatesList[0],
                    offset: 0,
                    length: count($rawDatesList[0]) / 2
                )
            );

            $checkoutDates = array_merge(
                $checkoutDates,
                array_slice(
                    array: $rawDatesList[0],
                    offset: count($rawDatesList[0]) / 2,
                    length: count($rawDatesList[0]) / 2
                )
            );
        }

        $checkinDates = array_unique($checkinDates);
        $checkoutDates = array_unique($checkoutDates);

        if (empty($checkinDates) && empty($checkoutDates)) {
            return false;
        }

        return [
            'checkinDates' => array_values($checkinDates),
            'checkoutDates' => array_values($checkoutDates)
        ];
    }

    private function buildRows(array $dates, array $rooms): array
    {
        $room_statuses = $rows = [];
        foreach ($rooms as $room) {
            for ($i = 0; $i < count($dates['checkinDates']); $i++) {
                $tour = (new ToursModel())->getTourByRoomIdAndDates(
                    room_id: $room['id'],
                    checkin_date: $dates['checkinDates'][$i],
                    checkout_date: $dates['checkoutDates'][$i]
                );

                if ($tour) {
                    $room_statuses[] = [
                        'room' => $room,
                        'checkin_date' => $dates['checkinDates'][$i],
                        'checkout_date' => $dates['checkoutDates'][$i],
                        'status' => 'busy',
                        'client' => ($client = (new ClientsModel())->get(
                            [
                                'column' => 'id',
                                'value' => $tour['owner_id']
                            ]
                        )[0]),
                        'count' => count(
                            (new ClientsModel())->getSubClients(
                                [
                                    'column' => 'main_client_id',
                                    'value' => $client['id']
                                ]
                            )
                        ) + 1
                    ];
                }

                if (
                    !$tour
                    && $this->roomHasDates(
                        room: $room,
                        checkinDate: $dates['checkinDates'][$i],
                        checkoutDate: $dates['checkoutDates'][$i]
                    )
                ) {
                    $room_statuses[] = [
                        'room' => $room,
                        'checkin_date' => $dates['checkinDates'][$i],
                        'checkout_date' => $dates['checkoutDates'][$i],
                        'status' => 'free',
                        'client' => false
                    ];
                }

                if (
                    !$tour
                    && !$this->roomHasDates(
                        room: $room,
                        checkinDate: $dates['checkinDates'][$i],
                        checkoutDate: $dates['checkoutDates'][$i]
                    )
                ) {
                    $room_statuses[] = [
                        'room' => $room,
                        'checkin_date' => $dates['checkinDates'][$i],
                        'checkout_date' => $dates['checkoutDates'][$i],
                        'status' => 'no date',
                        'client' => false
                    ];
                }
            }
        }

        for ($i = 0; $i < count($dates['checkinDates']); $i++) {
            $row = [
                'checkin_date' => $dates['checkinDates'][$i],
                'checkout_date' => $dates['checkoutDates'][$i],
                'room_statuses' => []
            ];

            foreach ($room_statuses as $room_status) {
                if (
                    $row['checkin_date'] == $room_status['checkin_date']
                    && $row['checkout_date'] == $room_status['checkout_date']
                ) {
                    $row['room_statuses'][] = $room_status;
                }
            }

            $rows[] = $row;
        }

        return $rows;
    }

    private function roomHasDates(array $room, string $checkinDate, string $checkoutDate): bool
    {
        $result = false;

        if (
            in_array($checkinDate, $room['dates']['checkinDates'])
            && in_array($checkoutDate, $room['dates']['checkoutDates'])
        ) {
            $result = true;
        }

        return $result;
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

}
