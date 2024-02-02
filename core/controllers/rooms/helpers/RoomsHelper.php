<?php

namespace core\controllers\rooms\helpers;

use core\services\IdGetter;

class RoomsHelper
{
    public function normalizeRoom(array &$room): array
    {
        $room['checkin_checkout_dates'] = rtrim($room['checkin_checkout_dates'], ", ");
        $room['checkin_checkout_dates'] = explode(", ", $room['checkin_checkout_dates'], strlen($room['checkin_checkout_dates']));

        $checkins = [];


        for ($i = 0; $i < count($room['checkin_checkout_dates']) / 2; $i++) {
            $checkins[] = $room['checkin_checkout_dates'][$i];
        }

        $checkouts = [];
        for ($i = count($room['checkin_checkout_dates']) / 2; $i < count($room['checkin_checkout_dates']); $i++) {
            $checkouts[] = $room['checkin_checkout_dates'][$i];
        }

        $room['checkin_checkout_dates'] = [];

        for ($i = 0; $i < count($checkins); $i++) {
            $room['checkin_checkout_dates'][] = $checkins[$i];
            $room['checkin_checkout_dates'][] = $checkouts[$i];
        }

        $room['comforts'] = explode(",", trim($room['comforts'], ", "), strlen($room['comforts']));
        $room['food'] = explode(",", trim($room['food'], ", "), strlen($room['food']));

        return $room;
    }

    public function normalizeRooms(array &$rooms): array
    {
        foreach ($rooms as &$room) {
            $room = $this->normalizeRoom($room);
        }

        return $rooms;
    }

    public function getHotelId(): int
    {
        $hotelId = IdGetter::getId();

        if ($hotelId != "") {
            return $hotelId;
        }

        return 0;
    }
}