<?php

namespace core\controllers\currencies;
use core\controllers\BaseController;
use core\views\currencies\CurrenciesView;

class CurrenciesController extends BaseController
{
    public function read(): void
    {

    }

    public function new(): void
    {
        $current_currencies = json_decode(file_get_contents(BASE_PATH . "config/currencies.json"), true);
        if (!$current_currencies) {
            $current_currencies = [];
        }
        $data = [
            'title' => 'Настроить валюты',
            'header' => 'Настроить валюты',
            'login' => $_COOKIE['login'],
            'current_currencies' => $current_currencies
        ];

        $this->setView(CurrenciesView::class);
        $this->view->render("currencies/new.html.twig", $data);
    }

    public function create(): void
    {
        $currencies = json_decode(file_get_contents("php://input"), true)['currencies'];

    $f = fopen(BASE_PATH . "config/currencies.json", "w");
        if ($f !== false) {
            fwrite($f, json_encode($currencies), strlen(json_encode($currencies)));
        } else {
            http_response_code(500);
        }

        fclose($f);
    }
}