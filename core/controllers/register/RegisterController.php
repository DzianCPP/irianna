<?php

namespace core\controllers\register;

use core\controllers\BaseController;
use core\views\register\RegisterView;

class RegisterController extends BaseController
{
    public function index(): void
    {
        $this->setView(RegisterView::class);
        $data = ["author" => "IriAnna", "title" => "IriANNA", "message" => "Register"];
        $this->view->render("register/register.html.twig", $data);
    }

    public function register(): void
    {
    }
}
