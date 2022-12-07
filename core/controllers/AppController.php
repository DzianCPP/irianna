<?php

namespace core\controllers;

class AppController extends BaseController
{
    private const VIEW_NAME = "core\\views\\app\\AppView";

    public function index(): void
    {
        $this->setView($this->VIEW_NAME);
        $this->view->render("main.html.twig");
    }
}
