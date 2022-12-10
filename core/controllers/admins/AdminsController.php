<?php

namespace core\controllers\admins;

use core\controllers\BaseController;
use core\views\admins\AdminsView;
use core\models\admins\AdminsModel;

class AdminsController extends BaseController
{
    private const PER_PAGE = 5;

    public function show(): void
    {
        if ($this->isLogged() && $this->isSuperAdmin()) {
            $this->setModel(AdminsModel::class);
            $admins = $this->model->getAllAdmins();
            $this->setView(AdminsView::class);
            $page = $this->getPage();
            $pages = (int)ceil(count($admins) / self::PER_PAGE);
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
                $this->notFound();
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
        $admin = $this->model->getAdminById($id)[0];
        $data = [
            'admin' => $admin,
            'title' => 'IriANNA',
            'author' => 'IriANNA',
            'message' => 'Введите новые данные'
        ];
        $this->view->render("admins/edit.html.twig", $data);
    }

    public function delete(): void
    {
        $jsonString = file_get_contents("php://input");
        $ids = json_decode($jsonString, true);
        if (count($ids) > 0) {
            $this->setModel(AdminsModel::class);
            if (!$this->model->deleteAdmin($ids)) {
                http_response_code(500);
            }
        }
    }

    public function create(): void
    {
        $newAdmin = json_decode(file_get_contents("php://input"), true);
        $this->setModel(AdminsModel::class);
        $this->model->insertAdmin($newAdmin);
    }

    public function update(): void
    {
        $jsonString = file_get_contents("php://input");
        $admin = json_decode($jsonString, true);
        $this->setModel(AdminsModel::class);
        if (!$this->model->editAdmin($admin)) {
            http_response_code(400);
        }
    }

    public function setPrivilege(array $admin): void
    {
        if ($admin['login'] === $_ENV['SUPER_ADMIN'] && $admin['password'] === $_ENV['SUPER_PASS']) {
            setcookie("superadmin", "1", time() + 28800, "/");
        } else {
            setcookie("superadmin", "0", time() + 28800, "/");
        }
    }

    private function isSuperAdmin(): bool
    {
        if (isset($_COOKIE['superadmin']) && $_COOKIE['superadmin'] === "1") {
            return true;
        }

        return false;
    }

    private function limitRange(array &$admins, int $requestedPage = 1): void
    {
        $rangeStart = $requestedPage * self::PER_PAGE - self::PER_PAGE;
        $rangeEnd = $rangeStart + self::PER_PAGE;

        $newAdmins = [];
        for ($i = $rangeStart; $i < $rangeEnd && $i < count($admins); ++$i) {
            $newAdmins[] = $admins[$i];
        }

        $admins = $newAdmins;
    }

    private function getPage(): int
    {
        $page = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_NUMBER_INT);
        if ($page == "") {
            $page = 1;
        }

        return $page;
    }

    private function notFound(): void
    {
        $data = [
            'title' => 'Add User App',
            'author' => 'Author: DzianCPP',
            'message' => '404: page not found'
        ];
        $this->view->render("404.html.twig", $data);
        http_response_code(404);
        return;
    }
}
