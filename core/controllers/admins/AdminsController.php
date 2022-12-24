<?php

namespace core\controllers\admins;

use core\controllers\BaseController;
use core\views\admins\AdminsView;
use core\models\admins\AdminsModel;
use core\controllers\AppController;
use core\controllers\ControllerInterface;

class AdminsController extends BaseController implements ControllerInterface
{
    protected const PER_PAGE = 5;

    public function read(int $id = 0): void
    {
        if ($this->isLogged() && $this->isSuperAdmin()) {
            $this->setModel(AdminsModel::class);
            $admins = $this->model->get();
            $this->setView(AdminsView::class);
            $page = $this->getPage();
            $pages = (int)ceil(count($admins) / parent::PER_PAGE);
            if ($page) {
                $this->limitRange($admins, $page);
            } else {
                $this->limitRange($admins);
            }

            $data = [
                'admins' => $admins,
                'thisPage' => $page,
                'pages' => $pages,
                'countAdmins' => count($admins),
                'title' => 'IriANNA',
                'author' => 'IriANNA',
                'login' => $_COOKIE['login']
            ];

            if (count($admins) === 0) {
                $this->view->render("admins/admins.html.twig", $data);
                return;
            }

            if ($page > $pages || $page < 1) {
                $appController = new AppController();
                $appController->notFound();
                return;
            }

            $this->view->render("admins/admins.html.twig", $data);
        } else {
            header("Location: " . "/admin");
            exit;
        }
    }

    public function edit(): void
    {
        $this->setModel(AdminsModel::class);
        $this->setView(AdminsView::class);
        $id = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_NUMBER_INT);
        $admin = $this->model->get(columnValue: ['column' => 'id', 'value' => $id]);
        $data = [
            'admin' => $admin[0],
            'title' => 'IriANNA',
            'author' => 'IriANNA',
            'message' => 'Введите новые данные'
        ];
        $this->view->render("admins/edit.html.twig", $data);
    }

    public function delete(int $id = 0): void
    {
        $jsonString = file_get_contents("php://input");
        $ids = json_decode($jsonString, true);
        if (count($ids) > 0) {
            $this->setModel(AdminsModel::class);
            if (!$this->model->delete(['column' => 'id', 'values' => $ids])) {
                http_response_code(500);
            }
        }
    }

    public function create(): void
    {
        $this->setModel(AdminsModel::class);
        $this->model->create();
    }

    public function update(int $id = 0): void
    {
        $jsonString = file_get_contents("php://input");
        $admin = json_decode($jsonString, true);
        $this->setModel(AdminsModel::class);
        if (!$this->model->update($admin)) {
            http_response_code(400);
        }
    }

    public function new(): void
    {
        header("Location: /registration");
        exit;
    }
}
