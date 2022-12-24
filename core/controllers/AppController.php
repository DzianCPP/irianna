<?php

namespace core\controllers;

use core\views\tours\ToursView;
use core\views\NotFoundView;

class AppController extends BaseController
{
    public function index(): void
    {
        if ($this->isLogged()) {
            $this->setView(ToursView::class);
            $data = ["author" => "IriAnna", "title" => "IriANNA", "message" => "Панель управления", "login" => $_COOKIE['login']];
            $this->view->render("tours/new.html.twig", $data);
        } else {
            header("Location: " . "/login");
            exit;
        }
    }
}
