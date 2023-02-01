<?php

namespace core\controllers\periods;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\views\periods\PeriodsView;
use core\models\periods\PeriodsModel;
use core\models\buses\BusesModel;

class PeriodsController extends BaseController implements ControllerInterface
{
    public function new(string $periodName = ""): void
    {
        $this->setView(PeriodsView::class);
        $this->setModel(PeriodsModel::class);
        $busesModel = new BusesModel();
        $data = [
            'name' => $periodName,
            'title' => 'Периоды',
            'buses' => $busesModel->get(),
            'author' => 'IriANNA',
            'header' => 'Добавить период',
            'login' => $_COOKIE['login']
        ];

        $this->view->render("periods/new.html.twig", $data);
    }

    public function edit(): void
    {
    }

    public function create(): void
    {
    }

    public function read(int $id = 0): void
    {
        $this->setModel(PeriodsModel::class);
        $periods = $this->model->get();
        $this->setView(PeriodsView::class);
        $page = $this->getPage();
        $busesModel = new BusesModel();
        $pages = (int)ceil(count($periods) / self::PER_PAGE);

        if ($page) {
            $this->limitRange($periods, $page);
        } else {
            $this->limitRange($periods);
        }

        $data = [
            'periods' => $periods,
            'currentPage' => $page,
            'pages' => $pages,
            'buses' => $busesModel->get(),
            'title' => 'Периоды',
            'author' => 'IriANNA',
            'login' => $_COOKIE['login']
        ];

        if ($page > $pages || $page < 1) {
            $this->notFound();
            return;
        }

        $this->view->render("periods/periods.html.twig", $data);
    }

    public function update(int $id = 0): void
    {
    }

    public function delete(int $id = 0): void
    {
    }
}
