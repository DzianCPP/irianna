<?php

namespace core\controllers;
use core\views\NotFoundView;

class BaseController
{
    protected $view;
    protected $model;
    private string $logDir = BASE_PATH . 'var/log';

    public function log(string $message): void
    {
        $file = scandir($this->logDir, SCANDIR_SORT_DESCENDING)[0];
        if (!$file) {
            $file = fopen(date('Y-m-d') . '_error.log', 'a+');
        }

        $result = fwrite($file, $message);

        if (!$result) {
            throw new \Exception('Could not write logs to file');
        }
    }

    protected const PER_PAGE = 10;

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

    public function notFound(): void
    {
        $this->setView(NotFoundView::class);
        $data = [
            'title' => 'Add User App',
            'author' => 'Author: DzianCPP',
            'message' => '404: страница не найдена'
        ];
        $this->view->render("notFound/404.html.twig", $data);
        http_response_code(404);
        return;
    }
}
