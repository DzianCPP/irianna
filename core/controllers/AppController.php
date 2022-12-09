<?php

namespace core\controllers;

use core\views\AppView;
use core\views\login\LoginView;

class AppController extends BaseController
{
    public function index(): void
    {
        if (isset($_COOKIE['logged']) && $_COOKIE['logged'] === "1") {
            $this->setView(AppView::class);
            $data = ["author" => "IriAnna", "title" => "IriANNA", "message" => "IriANNA"];
            $this->view->render("main.html.twig", $data);
        } else {
            $this->setView(LoginView::class);
            $data = ["author" => "IriAnna", "title" => "IriANNA", "message" => "IriANNA"];
            $this->view->render("login/login.html.twig", $data);
        }
    }
}
