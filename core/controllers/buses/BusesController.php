<?php

namespace core\controllers\buses;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\views\buses\BusesView;
use core\models\buses\BusesModel;
use core\services\IdGetter;
use core\controllers\buses\helpers\BusesHelper;

class BusesController extends BaseController implements ControllerInterface
{
    public function new(string $busName = ""): void
    {
        $this->setView(BusesView::class);
        $this->setModel(BusesModel::class);
        $data = [
            'name' => $busName,
            'title' => 'Автобусы',
            'author' => 'IriANNA',
            'header' => 'Добавить автобус',
            'login' => $_COOKIE['login']
        ];

        $this->view->render("buses/new.html.twig", $data);
    }

    public function edit(): void
    {
        $this->setModel(BusesModel::class);
        $this->setView(BusesView::class);
        $id = IdGetter::getId();
        $bus = $this->model->get(columnValue: ['column' => 'id', 'value' => $id])[0];
        $bus = BusesHelper::datesToArray($bus);

        $data = [
            'title' => "Изменить рейс",
            'header' => "Изменить рейс",
            'login' => $_COOKIE['login'],
            'bus' => $bus
        ];

        $this->view->render("buses/edit.html.twig", $data);
    }

    public function create(): void
    {
        $this->setModel(BusesModel::class);
        $this->model->create();
    }

    public function read(int $id = 0): void
    {
        if (!$this->isLogged()) {
            header("Location: " . "/admin");
            exit;
        }

        $this->setModel(BusesModel::class);
        $buses = $this->model->get();
        $this->setView(BusesView::class);
        $page = $this->getPage();
        $pages = (int)ceil(count($buses) / self::PER_PAGE);

        if ($page) {
            $this->limitRange($buses, $page);
        } else {
            $this->limitRange($buses);
        }

        $data = [
            'buses' => $buses,
            'currentPage' => $page,
            'pages' => $pages,
            'title' => 'Автобусы',
            'author' => 'IriANNA',
            'login' => $_COOKIE['login']
        ];

        if ($page > $pages || $page < 1) {
            $this->notFound();
            return;
        }

        $this->view->render("buses/buses.html.twig", $data);
    }

    public function update(int $id = 0): void
    {
    }

    public function delete(int $id = 0): void
    {
    }
}
