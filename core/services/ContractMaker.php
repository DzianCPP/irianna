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

        $new_contract = str_replace('day', '<b>' . $contractData['day'], $new_contract);
        $new_contract = str_replace('month', $contractData['month'], $new_contract);
        $new_contract = str_replace('year', $contractData['year'] . '</b>', $new_contract);
        $new_contract = str_replace('resort_name', $contractData['resort_name'], $new_contract);
        $new_contract = str_replace('hotel_name', $contractData['hotel_name'], $new_contract);
        $new_contract = str_replace('from_minsk_date', '<b>' . str_replace('-', '.', $contractData['from_minsk_date']), $new_contract);
        $new_contract = str_replace('arrival_to_minsk', str_replace('-', '.', $contractData['to_minsk_date']) . '</b>', $new_contract);
        $new_contract = str_replace('manager_name', '<b>' . $contractData['manager_name'] . '</b>', $new_contract);
        $new_contract = str_replace('client_name', '<b>' . $contractData['client_name'] . '</b>', $new_contract);
        $new_contract = str_replace('total_people', '<b>' . $contractData['total_people'] . '</b>', $new_contract);
        $new_contract = str_replace('number_of_children', '<b>' . $contractData['number_of_children'] . '</b>', $new_contract);
        $new_contract = str_replace('age_of_children', '<b>' . $contractData['age_of_children'] . '</b>', $new_contract);
        $new_contract = str_replace('passport_number', $contractData['passport_number'], $new_contract);
        $new_contract = str_replace('main_phone }}', '<b>' . $contractData['main_phone'] . '</b>', $new_contract);
        $new_contract = str_replace('main_phone', '<b>' . $contractData['main_phone'] . '</b>', $new_contract);
        $new_contract = str_replace('second_phone', '<b>' . $contractData['second_phone'] . '</b>', $new_contract);
        $new_contract = str_replace('service_cost_in_BYN', '<b>' . $contractData['service_cost_in_BYN'] . '</b>', $new_contract);
        $new_contract = str_replace('tour_price_in_curr', '<b>' . $contractData['tour_price_in_curr'], $new_contract);
        $new_contract = str_replace('currency', $contractData['currency'] . '</b>', $new_contract);
        $new_contract = str_replace('irianna_logo', '<img src="/assets/images/logos/logo.png">', $new_contract);
        $new_contract = str_replace('country', '<b>' . $contractData['country'] . '</b>', $new_contract);
        $new_contract = str_replace('чем за 20 дней до его начала', '<b>чем за 20 дней до его начала</b>', $new_contract);
        $new_contract = str_replace('Заказчик имеет право', '<b>Заказчик имеет право</b>', $new_contract);
        $new_contract = str_replace('Заказчик обязан', '<b>Заказчик обязан</b>', $new_contract);
        $new_contract = str_replace('при условия считаются принятыми и претензии в дальнейшем не принимаются.', '<b>при заселении в предоставленные номера, условия считаются принятыми и претензии в дальнейшем не принимаются.</b>', $new_contract);
        $new_contract = str_replace('менее чем за 20 дней', '<b>менее чем за 20 дней</b>', $new_contract);
        $new_contract = str_replace('туристической услуги', '<b>туристической услуги</b>', $new_contract);
        $new_contract = str_replace('времени ожидания перед заселением (2-3 часа) для уборки номера', '<b>времени ожидания перед заселением (2-3 часа) для уборки номера</b>', $new_contract);
        $new_contract = str_replace('(п. 3.4.9.,п.3.4.10. то есть если условие не соответствует, нельзя расселятся, если расселились условия считаются приняты и в дальнейшем претензии не принимаются)', '<b>(п. 3.4.9.,п.3.4.10. то есть если условие не соответствует, нельзя расселятся, если расселились условия считаются приняты и в дальнейшем претензии не принимаются)</b>', $new_contract);
        $new_contract = str_replace('будет производиться отстой автобуса в течение 9 часов', '<b>будет производиться отстой автобуса в течение 9 часов</b>', $new_contract);
        $new_contract = str_replace('"Исполнитель"', '<b>"Исполнитель"</b>', $new_contract);
        $new_contract = str_replace('"Заказчик"', '<b>"Заказчик"</b>', $new_contract);

        return $new_contract;
    }
}