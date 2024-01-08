<?php

namespace core\services;

class ContractMaker
{
    public static function prepareContract(string $contract, array $contractData): string
    {
        $new_contract = $contract;
        $transit = $contractData['only_transit'];

        $new_contract = str_replace('tour_price_in_curr_1', $contractData['total_travel_cost_curr_1'], $new_contract);
        $new_contract = str_replace('currency_1', $contractData['currency_1'], $new_contract);
        $new_contract = str_replace('day', '<b>' . $contractData['day'], $new_contract);
        $new_contract = str_replace('month', $contractData['month'], $new_contract);
        $new_contract = str_replace('year', $contractData['year'] . '</b>', $new_contract);
        $new_contract = str_replace('resort_name', $contractData['resort_name'], $new_contract);
        if ($transit) {
            $new_contract = str_replace('hotel_name', '', $new_contract);
        } else {
            $new_contract = str_replace('hotel_name', $contractData['hotel_name'], $new_contract);
        }
        $new_contract = str_replace('from_minsk_date', '<b>' . str_replace('-', '.', $contractData['from_minsk_date']), $new_contract);
        $new_contract = str_replace('arrival_to_minsk', str_replace('-', '.', $contractData['arrival_to_minsk']) . '</b>', $new_contract);
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
        $new_contract = str_replace('tour_price_in_curr_2', '<b>' . $contractData['tour_price_in_curr'], $new_contract);
        $new_contract = str_replace('currency_2', $contractData['currency'] . '</b>', $new_contract);
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

    public static function prepareAttachment2(string $att, array $data): string
    {
        $new_att = $att;

        $new_att = str_replace('hotel_name', $data['hotel_name'], $new_att);
        $new_att = str_replace('resort_name', $data['resort_name'], $new_att);
        $new_att = str_replace('hotel_area', $data['hotel_area'], $new_att);
        $new_att = str_replace('hotel_beach', $data['hotel_beach'], $new_att);
        $new_att = str_replace('hotel_housing', $data['hotel_housing'], $new_att);
        $new_att = str_replace('room_description', $data['room_description'], $new_att);
        $new_att = str_replace('room_water', $data['room_water'], $new_att);
        $new_att = str_replace('room_food', rtrim($data['room_food'], ','), $new_att);
        $new_att = str_replace('room_features', $data['room_features'], $new_att);
        $new_att = str_replace('from_minsk_date', $data['from_minsk_date'], $new_att);
        $new_att = str_replace('arrival_to_minsk', $data['arrival_to_minsk'], $new_att);
        $new_att = str_replace('from_resort_date', $data['to_minsk_date'], $new_att);
        $new_att = str_replace('hotel_address', $data['hotel_address'], $new_att);
        $new_att = str_replace('bus_route', $data['bus_route'], $new_att);
        $new_att = str_replace('_note', $data['_note'], $new_att);
        $new_att = str_replace('client_name', $data['client_name'], $new_att);
        $new_att = str_replace('room_comforts', rtrim($data['room_comforts'], ','), $new_att);

        return $new_att;
    }

    public static function prepareVoucher(string $v, array $d): string
    {
        $new_v = $v;

        $new_v = str_replace('irianna_logo', '<img src="/assets/images/logos/logo.png">', $new_v);
        $new_v = str_replace('client_name', $d['client_name'], $new_v);
        $new_v = str_replace('client_birthdate', $d['client_birthdate'], $new_v);
        $new_v = str_replace('client_passport', $d['client_passport'], $new_v);
        $new_v = str_replace('client_main_phone', $d['client_main_phone'], $new_v);
        $new_v = str_replace('client_second_phone', $d['client_second_phone'], $new_v);
        $new_v = str_replace('client_address', $d['client_address'], $new_v);
        $new_v = str_replace('bus_route', $d['bus_route'], $new_v);
        $new_v = str_replace('from_minsk_date', $d['from_minsk_date'], $new_v);
        $new_v = str_replace('arrival_to_minsk', $d['arrival_to_minsk'], $new_v);
        $new_v = str_replace('service_cost_in_BYN', $d['service_cost_in_BYN'], $new_v);
        $new_v = str_replace('tour_price_in_curr_1', $d['total_travel_cost_curr_2'], $new_v);
        $new_v = str_replace('currency_1', $d['currency_1'], $new_v);
        $new_v = str_replace('tour_price_in_curr_2', $d['tour_price_in_curr_1'], $new_v);
        $new_v = str_replace('currency_2', $d['currency_2'], $new_v);
        $new_v = str_replace('room_description', $d['room_description'], $new_v);
        $new_v = str_replace('room_food', rtrim($d['room_food'], ','), $new_v);
        $new_v = str_replace('transfer_direction', $d['transfer_direction'], $new_v);
        $new_v = str_replace('transfer_type', $d['transfer_type'], $new_v);
        $new_v = str_replace('today_date', $d['today_date'], $new_v);
        $new_v = str_replace('hotel_name', $d['hotel_name'], $new_v);
        $new_v = str_replace('resort_name', $d['resort_name'], $new_v);

        $room_comforts_array = explode(',', $d['room_comforts']);
        $room_comforts_str = '';

        for ($i = 0; $i < 3; ++$i) {
            $room_comforts_str .= $room_comforts_array[$i] . ', ';
        }
        $new_v = str_replace('room_comforts', rtrim($room_comforts_str, ', '), $new_v);
        if ($d['sub_clients'] == '' || $d['sub_clients'] == ', , ') {
            $d['sub_clients'] = '<br><br><br>';
        }
        $new_v = str_replace('sub_clients', rtrim($d['sub_clients'], ','), $new_v);

        return $new_v;
    }
}