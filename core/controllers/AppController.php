<?php

namespace core\controllers;

use core\views\AppView;

class AppController extends BaseController
{
    public function index(): void
    {
        $this->setView(AppView::class);
        $data = ["author" => "IriAnna", "title" => "IriANNA", "message" => "IriANNA"];
        $this->view->render("main.html.twig", $data);
    }
}
