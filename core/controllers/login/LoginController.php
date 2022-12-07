<?php

namespace core\controllers\login;

use core\controllers\BaseController;
use core\views\login\LoginView;

class LoginController extends BaseController
{
    public function index(): void
    {
        $this->setView(LoginView::class);
        $data = ["author" => "IriAnna", "title" => "IriANNA", "message" => "Login"];
        $this->view->render("login/login.html.twig", $data);
    }

    public function login(): void
    {
        http_response_code(401);
        return;
    }
}
