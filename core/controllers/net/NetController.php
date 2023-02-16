<?php

namespace core\controllers\net;

use core\controllers\BaseController;
use core\controllers\rooms\helpers\RoomsHelper;
use core\models\clients\ClientsModel;
use core\models\hotels\HotelsModel;
use core\models\rooms\RoomsModel;
use core\models\tours\ToursModel;
use core\services\IdGetter;
use core\views\net\NetView;

class NetController extends BaseController
{

    public function read(): void
    {
        $this->setView(NetView::class);
        $roomsHelper = new RoomsHelper();
        $hotel = $this->getHotel();
        if (!$hotel) {
            $this->renderEmptyPage('Не удалось найти отель');
            return;
        }

        $rooms = $this->getRooms($hotel['id']);
        if (!$rooms) {
            $this->renderEmptyPage('Не удалось найти номера');
            return;
        }

        $tours = $this->getTours($hotel['id']);
        if (!$tours) {
            $this->renderEmptyPage('Не удалось найти туры');
            return;
        }

        $clients = $this->getClients($tours);
        $roomsHelper->normalizeRooms($rooms);
        $this->removeF($rooms);
        $raw_dates = $this->getRawDates($rooms);
        $this->dateToMySQLDate($raw_dates);
        sort($raw_dates);
        foreach ($rooms as &$room) {
            $this->dateToMySQLDate($room['checkin_checkout_dates']);
            sort($room['checkin_checkout_dates']);
        }

        $table = [];

        $this->setTableHeaders($table, $rooms);
        $this->setNoDates($raw_dates, $rooms);
        //$this->setTableRows($table, $rooms, $raw_dates, $clients, $tours);
    }

    private function setNoDates(array &$raw_dates, array &$rooms): void
    {
        for ($i = 0; $i < count($raw_dates); $i+=2) {
            foreach ($rooms as &$room) {
                if ($room['checkin_checkout_dates'][$i] != $raw_dates[$i]) {
                    $beginning = array_slice($room['checkin_checkout_dates'], 0, $i);
                    $end = array_slice($room['checkin_checkout_dates'], $i);
                    $insert_array = [ "no", "no" ];
                    $new_array = [];
                    foreach ($beginning as &$b) {
                        $new_array[] = $b;
                    }
                    foreach ($insert_array as &$ia) {
                        $new_array[] = $ia;
                    }
                    foreach ($end as &$e) {
                        $new_array[] = $e;
                    }

                    $room['checkin_checkout_dates'] = $new_array;
                }
            }
        }
    }

    private function dateToMySQLDate(array &$dates) {
        foreach ($dates as &$date) {
            $date = substr($date, 6) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
        }
    }

    private function setTableRows(array &$table, array &$rooms, array &$raw_dates, array &$clients, array &$tours): void
    {
        $table['rows'] = [];

        for ($i = 0, $table_row = 0; $i < count($raw_dates); $i += 2) {
            $table['rows'][$table_row][] = $raw_dates[$i] . ' - ' . $raw_dates[$i + 1];
            foreach ($rooms as &$room) {
                if ($room['checkin_checkout_dates'][$i] != $raw_dates[$i]) {
                    $table['rows'][$table_row][] = 'no';
                    $this->setEmptyCell($table, $room, $raw_dates, $i, $table_row);
                }
            }
            $table_row++;
        }
    }


    private function setEmptyCell(array &$table, array &$room, array &$raw_dates, int $i, int $table_row): void
    {
        $table['rows'][$table_row][] = 'no';
        $beginning = array_slice($room['checkin_checkout_dates'], 0, $i);
        $insert_array = [$raw_dates[$i], $raw_dates[$i + 1]];
        $end = array_slice($room['checkin_checkout_dates'], $i, count($room['checkin_checkout_dates']));
        $total_array = [];
        foreach ($beginning as $b) {
            $total_array[] = $b;
        }
        foreach ($insert_array as $ia) {
            $total_array[] = $ia;
        }
        foreach ($end as $e) {
            $total_array[] = $e;
        }

        $room['checkin_checkout_dates'] = $total_array;
    }
    private function removeF(array &$rooms): void
    {
        foreach ($rooms as &$room) {
            foreach ($room['checkin_checkout_dates'] as &$date) {
                $date = ltrim($date, 'f');
            }
        }
    }

    private function setTableHeaders(array &$table, array &$rooms): void
    {
        $table['headers'] = [];

        foreach ($rooms as &$room) {
            $table['headers'][] = $room['description'];
        }
    }

    private function getRawDates(array &$rooms): array
    {
        $checkins = $checkouts = $raws = [];

        foreach ($rooms as &$room) {
            for ($i = 0; $i < count($room['checkin_checkout_dates']); $i += 2) {
                $in = $room['checkin_checkout_dates'][$i];
                $out = $room['checkin_checkout_dates'][$i + 1];

                if (!in_array($in, $checkins)) {
                    $checkins[] = $in;
                }

                if (!in_array($out, $checkouts)) {
                    $checkouts[] = $out;
                }
            }
        }

        for ($i = 0; $i < count($checkins); $i++) {
            $raws[] = $checkins[$i];
            $raws[] = $checkouts[$i];
        }

        return $raws;
    }

    private function getClients(array $tours): bool|array
    {
        if (count($tours) < 1) {
            return false;
        }

        $clientsModel = new ClientsModel();
        $clients = [];

        foreach ($tours as &$tour) {
            $client = $clientsModel->get(columnValue: ['column' => 'id', 'value' => $tour['owner_id']]);
            if (count($client) != 0) {
                $client = $client[0];
                $clients[] = $client;
            }
        }

        if (count($clients) > 0) {
            return $clients;
        }

        return false;
    }

    private function getHotel(): bool|array
    {
        $hotelsModel = new HotelsModel();
        $hotel_id = IdGetter::getId();
        $hotel = [];

        if ($hotel_id == 0) {
            $hotel = $hotelsModel->get();
        }

        if ($hotel_id != 0) {
            $hotel = $hotelsModel->get(columnValue: ['column' => 'id', 'value' => $hotel_id]);
        }

        if (count($hotel) > 0) {
            return $hotel[0];
        }

        return false;
    }

    private function getTours(int $hotel_id): bool|array
    {
        if ($hotel_id == 0) {
            return false;
        }

        $toursModel = new ToursModel();
        $tours = $toursModel->get(columnValue: ['column' => 'hotel_id', 'value' => $hotel_id]);

        if (count($tours) > 0) {
            return $tours;
        }

        return false;
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
// public function read(): void
// {
//     $this->setView(NetView::class);
//     $data = [];
//     $hotel_id = IdGetter::getId();

//     $hotelsModel = new HotelsModel();

//     if ($hotel_id != 0) {
//         $hotel = $hotelsModel->get(['column' => 'id', 'value' => $hotel_id])[0];
//     } else {
//         $hotel = $hotelsModel->get()[0];
//     }

//     $hotel_id = $hotel['id'];

//     $roomsModel = new RoomsModel();
//     $rooms = $roomsModel->get(['column' => 'hotel_id', 'value' => $hotel_id]);
//     $roomsHelper = new RoomsHelper();
//     $rooms = $roomsHelper->normalizeRooms($rooms);

//     $toursModel = new ToursModel();
//     $tours = $toursModel->get(['column' => 'hotel_id', 'value' => $hotel_id]);

//     $clientsModel = new ClientsModel();
//     $clients = [];
//     $sub_clients = [];

//     foreach ($tours as $tour) {
//         $clients[] = $clientsModel->get(['column' => 'id', 'value' => $tour['owner_id']])[0];
//         $sub_clients[] = $clientsModel->getSubClients(['column' => 'main_client_id', 'value' => $tour['owner_id']]);
//     }

//     $this->removeLettersF($rooms);

//     $raw_checkin_checkout_dates = $this->getRawCheckinCheckoutDates($rooms);

//     $this->magic($rooms, $tours, $clients, $raw_checkin_checkout_dates);

//     $table_headers = [];
//     $table_headers[] = 'Описание номеров -->';

//     foreach ($rooms as &$room) {
//         $table_headers[] = $room['description'];
//     }

//     $table_rows = [];

//     for ($i = 0; $i < count($raw_checkin_checkout_dates); ) {
//         $table_rows[]['col_0'] = ltrim($raw_checkin_checkout_dates[$i], 'f') . ' - ' . ltrim($raw_checkin_checkout_dates[$i + 1], 'f');
//         $i = $i + 2;
//     }

//     for ($r = 0, $tr = 0, $d = 0; $r < count($rooms); ) {
//         if (isset($rooms[$r]) && isset($rooms[$r]['checkin_checkout_dates'][$d])) {
//             $table_rows[$tr]['cols'][] = $rooms[$r]['checkin_checkout_dates'][$d];
//         }
//         $r++;
//         if ($r == count($rooms)) {
//             $r = 0;
//             $tr++;
//             $d += 2;

//             if ($tr == count($table_rows)) {
//                 break;
//             }
//         }
//     }


//     $data = [
//         'title' => 'Сетка номеров',
//         'header' => 'Сетка номеров',
//         'login' => $_COOKIE['login'],
//         'rooms' => $rooms,
//         'hotel' => $hotel,
//         'raw_dates' => $raw_checkin_checkout_dates,
//         'hotels' => $hotelsModel->get(),
//         'table_headers' => $table_headers,
//         'table_rows' => $table_rows,
//         'current_hotel_id' => $hotel_id
//     ];

//     $this->view->render("net/net.html.twig", $data);
// }

// private function magic(array &$rooms, array &$tours, array &$clients, array $raws): void
// {


//     // foreach ($rooms as &$room) {
//     //     for ($l = 1; $l < count($room['checkin_checkout_dates']); $l += 2) {
//     //         $date = & $room['checkin_checkout_dates'][$l];
//     //         foreach ($tours as $tour) {
//     //             $d = $tour['checkout_date'];
//     //             if ($d == $date && $room['id'] == $tour['room_id']) {
//     //                 $date = 'b' . $date;
//     //                 for ($i = 1; $i < count($room['checkin_checkout_dates']); $i += 2) {
//     //                     if ($room['checkin_checkout_dates'][$i] == $date) {
//     //                         $client = [];
//     //                         foreach ($clients as $c) {
//     //                             if ($c['id'] == $tour['owner_id']) {
//     //                                 $client = $c;
//     //                             }
//     //                         }

//     //                         if ($client != []) {
//     //                             $date = str_replace($room['checkin_checkout_dates'][$i], $client['name'], $room['checkin_checkout_dates'][$i]);
//     //                             $room['checkin_checkout_dates'][$i - 1] = str_replace($room['checkin_checkout_dates'][$i - 1], $client['name'], $room['checkin_checkout_dates'][$i - 1]);
//     //                         }
//     //                     }
//     //                 }
//     //             }
//     //         }
//     //     }
//     // }
// }
}