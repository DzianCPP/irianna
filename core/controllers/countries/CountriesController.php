<?php

namespace core\controllers\countries;

use core\controllers\BaseController;
use core\views\countries\CountriesView;
use core\models\countries\CountriesModel;
use core\controllers\AppController;


class CountriesController extends BaseController
{
    private const PER_PAGE = 5;

    public function show(): void
    {
        if ($this->isLogged()) {
            $this->setModel(CountriesModel::class);
            $countries = $this->model->getAllCountries();
            $this->setView(CountriesView::class);
            $page = $this->getPage();
            $pages = (int)ceil(count($countries) / self::PER_PAGE);
            if ($page) {
                $this->limitRange($countries, $page);
            } else {
                $this->limitRange($countries);
            }

            $data = [
                'countries' => $countries,
                'thisPage' => $page,
                'pages' => $pages,
                'countCountries' => count($countries),
                'title' => 'IriANNA',
                'author' => 'IriANNA',
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

            $this->view->render("admins/admins.html.twig", $data);
        } else {
            header("Location: " . "/admin");
            exit;
        }
    }

    public function new(string $countryName = '', int $is_active = 0): void
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
        $newCountry = json_decode(file_get_contents("php://input"), true);
        $this->setModel(CountriesModel::class);
        $this->model->insertCountry($newCountry);
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
