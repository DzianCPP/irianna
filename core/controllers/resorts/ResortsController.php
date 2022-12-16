<?php

namespace core\controllers\resorts;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\models\resorts\ResortsModel;
use core\views\resorts\ResortsView;
use core\models\countries\CountriesModel;
use core\views\countries\CountriesView;

class ResortsController extends BaseController implements ControllerInterface
{
    public function new(string $resortName = "", int $is_active = 0): void
    {
        $this->setView(ResortsView::class);
        $this->setModel(ResortsModel::class);
        $countriesModel = new CountriesModel();
        $countries = $countriesModel->get();
        $data = [
            'name' => $resortName,
            'is_active' => $is_active,
            'countries' => $countries,
            'title' => 'IriANNA',
            'author' => 'IriANNA',
            'header' => 'Добавить курорт',
            'login' => $_COOKIE['login']
        ];

        $this->view->render("resorts/new.html.twig", $data);
    }
    public function edit(): void
    {
    }
    public function create(): void
    {
    }
    public function read(int $id = 0): void
    {
        if (!$this->isLogged()) {
            header("Location: " . "/admin");
            exit;
        }

        $this->setModel(ResortsModel::class);
        $countriesModel = new CountriesModel();
        $countries = $countriesModel->get();
        $resorts = $this->model->get();
        $this->setView(ResortsView::class);
        $page = $this->getPage();
        $pages = (int)ceil(count($resorts) / parent::PER_PAGE);
        if ($page) {
            $this->limitRange($resorts, $page);
        } else {
            $this->limitRange($resorts);
        }

        $data = [
            'resorts' => $resorts,
            'countries' => $countries,
            'currentPage' => $page,
            'pages' => $pages,
            'title' => 'IriANNA',
            'author' => 'IriANNA',
            'login' => $_COOKIE['login'],
            'header' => 'Курорты'
        ];

        if ($page > $pages || $page < 1) {
            $this->notFound();
            return;
        }

        $this->view->render("resorts/resorts.html.twig", $data);
    }
    public function update(int $id = 0): void
    {
    }
    public function delete(int $id = 0): void
    {
    }
}
