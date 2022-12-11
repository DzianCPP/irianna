<?php

namespace core\controllers;

use core\views\AppView;
use core\views\NotFoundView;

class AppController extends BaseController
{
    public function index(): void
    {
        if ($this->isLogged()) {
            $this->setView(AppView::class);
            $data = ["author" => "IriAnna", "title" => "IriANNA", "message" => "Панель управления", "login" => $_COOKIE['login']];
            $this->view->render("main.html.twig", $data);
        } else {
            header("Location: " . "/login");
            exit;
        }
    }

    public static function notFound(): void
    {
        if (parent::isLogged()) {
            parent::setView(NotFoundView::class);
            $data = ["author" => "IriAnna", "title" => "IriAnna", "message" => "404 Страница не найдена", "login" => $_COOKIE['login']];
            http_response_code(404);
            parent::$view->render("notFound/404.html.twig", $data);
        }
    }
}
