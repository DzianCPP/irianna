<?php

namespace core\controllers\register;

use core\controllers\BaseController;
use core\views\register\RegisterView;
use core\models\admins\AdminsModel;

class RegisterController extends BaseController
{
    private AdminsModel $adminsModel;

    public function index(): void
    {
        $this->setView(RegisterView::class);
        $data = ["author" => "IriAnna", "title" => "IriANNA", "message" => "Register"];
        $this->view->render("register/register.html.twig", $data);
    }

    public function register(): void
    {
        $this->adminsModel = new AdminsModel();
        $data = [];
        $this->adminsModel->insertAdmin($data);
    }
}
