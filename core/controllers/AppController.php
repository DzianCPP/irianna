<?php

namespace core\controllers;

use core\views\AppView;
use core\views\tours\ToursView;
use core\views\NotFoundView;

class AppController extends BaseController
{
    public function index(): void
    {
        $this->setView(ToursView::class);
        $data = ["author" => "IriAnna", "title" => "IriANNA", "header" => "Новый тур", "login" => $_COOKIE['login']];
        $this->view->render("tours/new.html.twig", $data);
    }

    public function dashboard(): void
    {
        $this->setView(AppView::class);
        $data = ["author" => "IriAnna", "title" => "IriANNA", "header" => "Панель управления", "login" => $_COOKIE['login']];
        $this->view->render("main.html.twig", $data);
    }
}