<?php

namespace core\controllers\buses\helpers;

class BusesHelper
{
    public static function datesToArray(array $bus): array
    {
        $bus['departure_from_minsk'] = explode("\n", $bus['departure_from_minsk']);
        $bus['arrival_to_minsk'] = explode("\n", $bus['arrival_to_minsk']);
        
        return $bus;
    }
}