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

    protected function notFound(): void
    {
        $data = [
            'title' => 'Add User App',
            'author' => 'Author: DzianCPP',
            'message' => '404: page not found'
        ];
        $this->view->render("notFound/404.html.twig", $data);
        http_response_code(404);
        return;
    }
}
