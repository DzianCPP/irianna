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
        $data = [];
        $hotel_id = IdGetter::getId();

        $hotelsModel = new HotelsModel();

        if ($hotel_id != 0) {
            $hotel = $hotelsModel->get(['column' => 'id', 'value' => $hotel_id])[0];
        } else {
            $hotel = $hotelsModel->get()[0];
        }

        $hotel_id = $hotel['id'];

        $roomsModel = new RoomsModel();
        $rooms = $roomsModel->get(['column' => 'hotel_id', 'value' => $hotel_id]);
        $roomsHelper = new RoomsHelper();
        $rooms = $roomsHelper->normalizeRooms($rooms);

        $toursModel = new ToursModel();
        $tours = $toursModel->get(['column' => 'hotel_id', 'value' => $hotel_id]);

        $clientsModel = new ClientsModel();
        $clients = [];
        $sub_clients = [];

        foreach ($tours as $tour) {
            $clients[] = $clientsModel->get(['column' => 'id', 'value' => $tour['owner_id']])[0];
            $sub_clients[] = $clientsModel->getSubClients(['column' => 'main_client_id', 'value' => $tour['owner_id']]);
        }
        $raw_checkin_checkout_dates = [];

        foreach ($rooms as &$room) {
            if (count($raw_checkin_checkout_dates) < count($room['checkin_checkout_dates'])) {
                $raw_checkin_checkout_dates = $room['checkin_checkout_dates'];
            }
        }

        $this->magic($rooms, $tours, $clients);

        $table_headers = [];
        $table_headers[] = 'Описание номеров -->';

        foreach ($rooms as &$room) {
            $table_headers[] = $room['description'];
        }

        $table_rows = [];

        for ($i = 0; $i < count($raw_checkin_checkout_dates); ) {
            $table_rows[]['col_0'] = ltrim($raw_checkin_checkout_dates[$i], 'f') . ' - ' . ltrim($raw_checkin_checkout_dates[$i + 1], 'f');
            $i = $i + 2;
        }
        
      for ($r = 0, $tr = 0, $d = 0; $r < count($rooms); ) {
            if (isset($rooms[$r]) && isset($rooms[$r]['checkin_checkout_dates'][$d])) {
                $table_rows[$tr]['cols'][] = $rooms[$r]['checkin_checkout_dates'][$d];
            }
            $r++;
            if ($r == count($rooms)) {
                $r = 0;
                $tr++;
                $d += 2;

                if ($tr == count($table_rows)) {
                    break;
                }
            }
        }


        $data = [
            'title' => 'Сетка номеров',
            'header' => 'Сетка номеров',
            'login' => $_COOKIE['login'],
            'rooms' => $rooms,
            'hotel' => $hotel,
            'raw_dates' => $raw_checkin_checkout_dates,
            'hotels' => $hotelsModel->get(),
            'table_headers' => $table_headers,
            'table_rows' => $table_rows,
            'current_hotel_id' => $hotel_id
        ];

        $this->view->render("net/net.html.twig", $data);
    }

    private function magic(array &$rooms, array &$tours, array &$clients): void
    {

        foreach ($rooms as &$room) {
            for ($l = 1; $l < count($room['checkin_checkout_dates']); $l += 2) {
                $date = & $room['checkin_checkout_dates'][$l];
                foreach ($tours as $tour) {
                    $d = 'f' . $tour['checkout_date'];
                    if ($d == $date && $room['id'] == $tour['room_id']) {
                        $date = str_replace('f', 'b', $date);
                        for ($i = 1; $i < count($room['checkin_checkout_dates']); $i += 2) {
                            if ($room['checkin_checkout_dates'][$i] == $date) {
                                $client = [];
                                foreach ($clients as $c) {
                                    if ($c['id'] == $tour['owner_id']) {
                                        $client = $c;
                                    }
                                }

                                if ($client != []) {
                                    $date = str_replace($room['checkin_checkout_dates'][$i], $client['name'], $room['checkin_checkout_dates'][$i]);
                                    $room['checkin_checkout_dates'][$i - 1] = str_replace($room['checkin_checkout_dates'][$i - 1], $client['name'], $room['checkin_checkout_dates'][$i - 1]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}