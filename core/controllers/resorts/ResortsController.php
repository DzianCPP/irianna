<?php

namespace core\controllers\resorts;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\models\resorts\ResortsModel;
use core\services\Paginator;
use core\views\resorts\ResortsView;
use core\models\countries\CountriesModel;
use core\services\IdGetter;

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
        $this->setModel(ResortsModel::class);
        $this->setView(ResortsView::class);
        $countries = new CountriesModel();

        $id = IdGetter::getId();

        $data = [
            'title' => 'IriANNA',
            'author' => 'IriANNA',
            'header' => 'Исправить курорт',
            'login' => $_COOKIE['login'],
            'resort' => $this->model->get(['column' => 'id', 'value' => $id])[0],
            'countries' => $countries->get()
        ];

        $this->view->render("resorts/edit.html.twig", $data);
    }

    public function create(): void
    {
        $this->setModel(ResortsModel::class);
        $this->model->create();
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
        
        $page = Paginator::getPage();
        $pages = (int)ceil(count($resorts) / parent::PER_PAGE);

        if ($page) {
            Paginator::limitRange($resorts, self::PER_PAGE, $page);
        } else {
            Paginator::limitRange($resorts, self::PER_PAGE);
        }

        $data = [
            'resorts' => $resorts,
            'entity' => 'resorts',
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
        $resort = json_decode(file_get_contents("php://input"), true);
        $this->setModel(ResortsModel::class);
        $this->model->update($resort);
    }

    public function delete(int $id = 0): void
    {
        $ids = json_decode(file_get_contents("php://input"), true);
        if (count($ids) < 1) {
            return;
        }

        $this->setModel(ResortsModel::class);
        if (!$this->model->delete([
            'column' => 'id',
            'values' => $ids
        ])) {
            http_response_code(500);
        };
    }
}
