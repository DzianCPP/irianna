<?php

namespace core\controllers\register;

use core\controllers\BaseController;
use core\views\register\RegisterView;

class RegisterController extends BaseController
{
    public function form(): void
    {
        $this->setView(RegisterView::class);
        $data = ["author" => "IriAnna", "title" => "IriANNA", "message" => "Регистрация"];
        $this->view->render("register/register.html.twig", $data);
    }
}
