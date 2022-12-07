<?php

namespace core\controllers;

class AppController extends BaseController
{
    public function index(): void
    {
        $this->setView("BaseView");
        $data = [
            'title' => 'Add User App',
            'author' => 'Author: DzianCPP'
        ];

        $this->view->render("main.html.twig", $data);
    }

    public function notFound(): void
    {
        $this->setView("BaseView");
        $data = [
            'title' => 'Add User App',
            'author' => 'Author: DzianCPP',
            'message' => '404: page not found'
        ];
        http_response_code(404);
        $this->view->render("404.html.twig", $data);
    }
}
