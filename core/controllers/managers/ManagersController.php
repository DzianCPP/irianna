<?php

namespace core\controllers\managers;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\models\managers\ManagersModel;
use core\services\IdGetter;
use core\views\managers\ManagersView;

class ManagersController extends BaseController implements ControllerInterface
{
    public function new(string $periodName = ""): void
    {
        $this->setView(ManagersView::class);
        $this->setModel(ManagersModel::class);
        $data = [
            'name' => $periodName,
            'title' => 'Менеджеры',
            'author' => 'IriANNA',
            'header' => 'Добавить менеджера',
            'login' => $_COOKIE['login']
        ];

        $this->view->render("managers/new.html.twig", $data);
    }

    public function edit(): void
    {
        $this->setView(ManagersView::class);
        $this->setModel(ManagersModel::class);
        $id = IdGetter::getId();
        $manager = $this->model->get(
            columnValue: [
                'column' => 'id',
                'value' => $id
            ]
        )[0];

        $data = [
            'title' => 'Изменить менеджера',
            'header' => 'Изменить менеджера',
            'manager' => $manager
        ];

        $this->view->render("managers/edit.html.twig", $data);
    }

    public function create(): void
    {
        $this->setModel(ManagersModel::class);
        $this->model->create();
    }

    public function read(int $id = 0): void
    {
        if (!$this->isLogged()) {
            header("Location: " . "/admin");
            exit;
        }

        $this->setModel(ManagersModel::class);
        $this->setView(ManagersView::class);
        $managers = $this->model->get();
        $page = $this->getPage();
        $pages = (int)ceil(count($managers) / self::PER_PAGE);

        if ($page) {
            $this->limitRange($managers, $page);
        } else {
            $this->limitRange($managers);
        }

        $data = [
            'managers' => $managers,
            'currentPage' => $page,
            'pages' => $pages,
            'title' => 'Менеджеры',
            'header' => 'Менеджеры',
            'author' => 'IriANNA',
            'login' => $_COOKIE['login']
        ];

        if ($pages > 1 && ($page > $pages || $page < 1)) {
            $this->notFound();
            return;
        }

        $this->view->render("managers/managers.html.twig", $data);
    }

    public function update(int $id = 0): void
    {
        $this->setModel(ManagersModel::class);
        $manager = json_decode(file_get_contents("php://input"), true);
        $this->model->update($manager);
    }

    public function delete(int $id = 0): void
    {
        $ids = json_decode(file_get_contents("php://input"), true);

        $this->setModel(ManagersModel::class);
        if (!$this->model->delete(
            columnValues: [
                'column' => 'id',
                'values' => $ids
            ]
        )) {
            http_response_code(500);
        }
    }
}
