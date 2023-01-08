<?php

namespace core\controllers\rooms\helpers;

use core\services\IdGetter;

class RoomsHelper
{
    public function normalizeRoom(array &$room): array
    {
        $room['checkin_checkout_dates'] = rtrim($room['checkin_checkout_dates'], ", ");
        $room['checkin_checkout_dates'] = explode(", ", $room['checkin_checkout_dates'], strlen($room['checkin_checkout_dates']));
        foreach ($room['checkin_checkout_dates'] as &$date) {
            $date = substr($date, 1);
        }
        
        $checkins = [];
        
        
        for ($i = 0; $i < count($room['checkin_checkout_dates']); $i += 2) {
            $checkins[] = $room['checkin_checkout_dates'][$i];
        }

        $checkouts = [];
        for ($i = 1; $i < count($room['checkin_checkout_dates']); $i += 2) {
            $checkouts[] = $room['checkin_checkout_dates'][$i];
        }

        $room['checkin_checkout_dates'] = [];
        $room['checkin_checkout_dates']['checkins'] = $checkins;
        $room['checkin_checkout_dates']['checkouts'] = $checkouts;

        $room['comforts'] = explode(",", trim($room['comforts'], ", "), strlen($room['comforts']));
        $room['food'] = explode(",", trim($room['food'], ", "), strlen($room['food']));
        
        return $room;
    }

    public function normalizeRooms(array &$rooms): array
    {
        foreach ($rooms as &$room) {
            $room['checkin_checkout_dates'] = rtrim($room['checkin_checkout_dates'], ", ");
            $room['checkin_checkout_dates'] = explode(", ", $room['checkin_checkout_dates'], strlen($room['checkin_checkout_dates']));
            $room['comforts'] = explode(",", trim($room['comforts']), strlen($room['comforts']));
            $room['food'] = explode(",", trim($room['food']), strlen($room['food']));
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