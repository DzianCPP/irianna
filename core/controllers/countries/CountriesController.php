<?php

namespace core\controllers\countries;

use core\controllers\BaseController;
use core\services\Paginator;
use core\views\countries\CountriesView;
use core\models\countries\CountriesModel;
use core\controllers\AppController;
use core\controllers\ControllerInterface;
use core\services\IdGetter;

class CountriesController extends BaseController implements ControllerInterface
{
    public function read(int $id = 0): void
    {
        $this->setModel(CountriesModel::class);
        $countries = $this->model->get();
        $this->setView(CountriesView::class);
        $page = Paginator::getPage();
        $pages = (int) ceil(count($countries) / self::PER_PAGE);
        if ($page) {
            Paginator::limitRange($countries, self::PER_PAGE, $page);
        } else {
            Paginator::limitRange($countries, self::PER_PAGE);
        }

        $data = [
            'countries' => $countries,
            'entity' => 'countries',
            'currentPage' => $page,
            'pages' => $pages,
            'countCountries' => count($countries),
            'title' => 'IriANNA',
            'author' => 'IriANNA',
            'header' => 'Страны',
            'login' => $_COOKIE['login']
        ];

        if (count($countries) === 0) {
            $this->view->render("countries/countries.html.twig", $data);
            return;
        }

        if ($page > $pages || $page < 1) {
            $appController = new AppController();
            $appController->notFound();
            return;
        }

        $this->view->render("countries/countries.html.twig", $data);
    }

    public function new (string $countryName = '', int $is_active = 0): void
    {
        $this->setView(CountriesView::class);
        $this->setModel(CountriesModel::class);
        $data = [
            'name' => $countryName,
            'is_active' => $is_active,
            'title' => 'IriANNA',
            'author' => 'IriANNA',
            'message' => 'Добавить страну',
            'login' => $_COOKIE['login']
        ];

        $this->view->render("countries/new.html.twig", $data);
    }

    public function edit(): void
    {
        $this->setModel(CountriesModel::class);
        $this->setView(CountriesView::class);
        $id = IdGetter::getId();
        $country = $this->model->get(['column' => 'id', 'value' => $id])[0];
        $data = [
            'country' => $country,
            'title' => 'IriANNA',
            'author' => 'IriANNA',
            'message' => 'Введите новые данные',
            'login' => $_COOKIE['login']
        ];
        $this->view->render("countries/edit.html.twig", $data);
    }

    public function delete(int $id = 0): void
    {
        $jsonString = file_get_contents("php://input");
        $ids = json_decode($jsonString, true);
        if (count($ids) > 0) {
            $this->setModel(CountriesModel::class);
            if (
                !$this->model->delete([
                    'column' => 'id',
                    'values' => $ids
                ])
            ) {
                http_response_code(500);
            }
        }
    }

    public function create(): void
    {
        $this->setModel(CountriesModel::class);
        $this->model->create();
    }

    public function update(int $id = 0): void
    {
        $jsonString = file_get_contents("php://input");
        $country = json_decode($jsonString, true);
        $this->setModel(CountriesModel::class);
        if (!$this->model->update($country)) {
            http_response_code(400);
        }
    }
}