<?php

namespace core\services;

class ContractMaker
{
    public static function prepareContract(string $contract, array $contractData): string
    {
        $new_contract = $contract;

        // $contractData = [
        //     'resort_name' => $resort['name'],
        //     'hotel_name' => $hotel['name'],
        //     'day' => date('d'),
        //     'month' => date('m'),
        //     'year' => date('Y'),
        //     'from_minsk_date' => $tour['from_minsk_date'],
        //     'arrival_to_minsk' => $bus['arrival_to_minsk'],
        //     'manager_name' => $manager['name'],
        //     'client_name' => $client['name'],
        //     'total_people' => 1 + count($sub_clients),
        //     'number_of_children' => $tour['number_of_children'],
        //     'age_of_children' => $age_of_children,
        //     'passport_number' => $client['passport'],
        //     'main_phone' => $client['main_phone'],
        //     'second_phone' => $client['second_phone']
        // ];

        $new_contract = str_replace('day', $contractData['day'], $new_contract);
        $new_contract = str_replace('month', $contractData['month'], $new_contract);
        $new_contract = str_replace('year', $contractData['year'], $new_contract);
        $new_contract = str_replace('resort_name', $contractData['resort_name'], $new_contract);
        $new_contract = str_replace('hotel_name', $contractData['hotel_name'], $new_contract);
        $new_contract = str_replace('from_minsk_date', str_replace('-', '.', $contractData['from_minsk_date']), $new_contract);
        $new_contract = str_replace('arrival_to_minsk', str_replace('-', '.', $contractData['to_minsk_date']), $new_contract);
        $new_contract = str_replace('manager_name', '<b>' . $contractData['manager_name'] . '</b>', $new_contract);
        $new_contract = str_replace('client_name', '<b>' . $contractData['client_name'] . '</b>', $new_contract);
        $new_contract = str_replace('total_people', $contractData['total_people'], $new_contract);
        $new_contract = str_replace('number_of_children', $contractData['number_of_children'], $new_contract);
        $new_contract = str_replace('age_of_children', $contractData['age_of_children'], $new_contract);
        $new_contract = str_replace('passport_number', $contractData['passport_number'], $new_contract);
        $new_contract = str_replace('main_phone }}', '<b>' . $contractData['main_phone'] . '</b>', $new_contract);
        $new_contract = str_replace('main_phone', '<b>' . $contractData['main_phone'] . '</b>', $new_contract);
        $new_contract = str_replace('second_phone', '<b>' . $contractData['second_phone'] . '</b>', $new_contract);
        $new_contract = str_replace('service_cost_in_BYN', $contractData['service_cost_in_BYN'], $new_contract);
        $new_contract = str_replace('tour_price_in_curr', $contractData['tour_price_in_curr'], $new_contract);
        $new_contract = str_replace('currency', $contractData['currency'], $new_contract);

        return $new_contract;
    }
}