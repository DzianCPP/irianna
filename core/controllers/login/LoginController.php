<?php

namespace core\controllers\login;

use core\controllers\BaseController;
use core\views\login\LoginView;
use core\models\admins\AdminsModel;

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
        $adminsModel = new AdminsModel();
        $json_string = file_get_contents("php://input");

        $admins = $adminsModel->getAllAdmins();

        $requested_admin = json_decode($json_string);

        foreach ($admins as $admin) {
            if ($admin['login'] == $requested_admin['login'] && $admin['password'] == $requested_admin['password']) {
                setcookie("logged", "1");
                http_response_code(205);
                return;
            }
        }
        http_response_code(401);
        return;
    }
}
