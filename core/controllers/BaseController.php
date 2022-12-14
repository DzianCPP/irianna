<?php

namespace core\controllers;

class BaseController
{
    protected $view;
    protected $model;

    protected const PER_PAGE = 5;

    protected function setView(string $nameView): void
    {
        $this->view = new $nameView();
    }

    protected function setModel(string $nameModel): void
    {
        $this->model = new $nameModel();
    }

    protected function isLogged(): bool
    {
        if (isset($_COOKIE['logged']) && $_COOKIE['logged'] === "1") {
            return true;
        }

        return false;
    }

    protected function setPrivilege(array $admin): void
    {
        if ($admin['login'] === $_ENV['SUPER_ADMIN'] && $admin['password'] === $_ENV['SUPER_PASS']) {
            setcookie("superadmin", "1", time() + 28800, "/");
        } else {
            setcookie("superadmin", "0", time() + 28800, "/");
        }
    }

    protected function isSuperAdmin(): bool
    {
        if (isset($_COOKIE['superadmin']) && $_COOKIE['superadmin'] === "1") {
            return true;
        }

        return false;
    }

    protected function limitRange(array &$records, int $requestedPage = 1): void
    {
        $rangeStart = $requestedPage * self::PER_PAGE - self::PER_PAGE;
        $rangeEnd = $rangeStart + self::PER_PAGE;

        $newRecords = [];
        for ($i = $rangeStart; $i < $rangeEnd && $i < count($records); ++$i) {
            $newRecords[] = $records[$i];
        }

        $records = $newRecords;
    }

    protected function getPage(): int
    {
        $page = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_NUMBER_INT);
        if ($page == "") {
            $page = 1;
        }

        return $page;
    }

    protected function notFound(): void
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
