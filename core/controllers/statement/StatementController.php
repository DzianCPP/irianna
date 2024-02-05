<?php

namespace core\controllers\statement;

use core\controllers\BaseController;
use core\models\buses\BusesModel;
use core\models\clients\ClientsModel;
use core\models\tours\ToursModel;
use core\views\statement\StatementView;

class StatementController extends BaseController
{
    private ToursModel $toursModel;
    private BusesModel $busesModel;
    private StatementView $statementView;
    private ClientsModel $clientsModel;

    public function __construct()
    {
        $this->busesModel = new BusesModel();
        $this->toursModel = new ToursModel();
        $this->statementView = new StatementView();
        $this->clientsModel = new ClientsModel();
    }
    public function form(): void
    {
        $data = [
            'buses' => $this->busesModel->get(['column' => 'archived', 'value' => 0]),
            'title' => 'Ведомость',
            'header' => 'Ведомость'
        ];

        $this->statementView->render('statement/form.html.twig', $data);
    }

    public function doc(): void
    {
        $params = json_decode(file_get_contents(BASE_PATH . 'static/search/request.json'), true);
        $tours = $this->toursModel->list(
            columnsValues: [
                'columns' => ['bus_id', 'from_minsk_date', 'arrival_to_minsk'],
                'values' => [$params['bus_id'], $params['from_minsk_date'], $params['to_minsk_date']]
            ]
        );

        $rub_total = $this->count_rub_total($tours);
        $usd_total = $this->count_usd_total($tours);
        $clients = $this->clientsModel->get(['column' => 'archived', 'value' => 0]);
        $data = [
            'tours' => $tours,
            'clients' => $clients,
            'title' => 'Ведомость',
            'header' => 'Ведомость',
            'entity' => 'statement',
            'login' => $_COOKIE['login'],
            'rub_total' => '<b>' . $rub_total . ' RUB</b>',
            'usd_total' => '<b>' . $usd_total . ' USD</b>',
            'bus' => $this->busesModel->get(columnValue: ['column' => 'id', 'value' => (int) $params['bus_id']])[0],
            'from_minsk_date' => $params['from_minsk_date'],
            'to_minsk_date' => $params['to_minsk_date']
        ];
        $this->statementView->render('statement/doc.html.twig', $data);
    }

    public function prepare(): void
    {
        $request = json_encode(json_decode(file_get_contents("php://input"), true));
        $f = fopen(BASE_PATH . 'static/search/request.json', 'w');
        if (!$f) {
            http_response_code(500);
            return;
        }

        fwrite($f, $request, strlen($request));
        fclose($f);

        http_response_code(200);
    }

    private function count_rub_total(array $tours): int
    {
        $rub_total = 0;
        foreach ($tours as $t) {
            $rub_total += (int) substr($t['total_travel_cost_byn'], 0, strpos($t['total_travel_cost_byn'], ' RUB', 0));
        }

        return $rub_total;
    }

    private function count_usd_total(array $tours): int
    {
        $usd_total = 0;
        foreach ($tours as $t) {
            $usd_total += (int) substr($t['total_travel_cost_currency'], 0, strpos($t['total_travel_cost_currency'], ' USD', 0));
        }

        return $usd_total;
    }
}