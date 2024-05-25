<?php

namespace core\controllers\buses;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\services\Paginator;
use core\views\buses\BusesView;
use core\models\buses\BusesModel;
use core\services\IdGetter;
use core\controllers\buses\helpers\BusesHelper;

class BusesController extends BaseController implements ControllerInterface
{
    public function new (string $busName = ""): void
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

    public function readOne(): void
    {
        $id = (int) IdGetter::getId();
        $this->setModel(BusesModel::class);
        $bus = $this->model->get(columnValue: ['column' => 'id', 'value' => $id]);
        if (count($bus) >= 1) {
            $bus = $bus[0];
        }

        if (count ($bus) < 1) {
            http_response_code(500);
            return;
        }
        $bus = json_encode($bus);
        echo $bus;
    }

    public function read(int $id = 0): void
    {
        $this->setModel(BusesModel::class);
        $buses = array_reverse($this->model->get(['column' => 'archived', 'value' => 0]));
        $filteredBuses = [];

        foreach ($buses as $bus) {
            if ($bus['archived'] != 1) {
                $filteredBuses[] = $bus;
            }
        }

        $buses = $filteredBuses;
        $this->setView(BusesView::class);
        $page = Paginator::getPage();
        $pages = (int) ceil(count($buses) / self::PER_PAGE);

        if ($page) {
            Paginator::limitRange($buses, self::PER_PAGE, $page);
        } else {
            Paginator::limitRange($buses, self::PER_PAGE);
        }

        $data = [
            'buses' => $buses,
            'entity' => 'buses',
            'currentPage' => $page,
            'pages' => $pages,
            'title' => 'Автобусы',
            'header' => 'Автобусы',
            'author' => 'IriANNA',
            'login' => $_COOKIE['login']
        ];

        $this->view->render("buses/buses.html.twig", $data);
    }

    public function update(int $id = 0): void
    {
        $bus = json_decode(file_get_contents("php://input"), true);
        $this->setModel(BusesModel::class);
        if (!$this->model->update($bus)) {
            http_response_code(500);
        }
    }

    public function delete(int $id = 0): void
    {
        $ids = json_decode(file_get_contents("php://input"), true);
        if (count($ids) < 1) {
            return;
        }

        $this->setModel(BusesModel::class);
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