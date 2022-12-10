<?php

namespace core\controllers\login;

use core\controllers\BaseController;
use core\views\login\LoginView;
use core\models\admins\AdminsModel;

class LoginController extends BaseController
{
    public function index(): void
    {
        if (!$this->isLogged()) {
            $this->setView(LoginView::class);
            $data = ["author" => "IriAnna", "title" => "IriANNA", "message" => "Login"];
            $this->view->render("login/login.html.twig", $data);
        } else {
            header("Location: " . "/admin");
            exit;
        }
    }

    public function login(): void
    {
        $adminsModel = new AdminsModel();
        $json_string = file_get_contents("php://input");

        $admins = $adminsModel->getAllAdmins();

        $requested_admin = json_decode($json_string, true);

        foreach ($admins as $admin) {
            if ($admin['login'] == $requested_admin['login'] && $admin['password'] == $requested_admin['password']) {
                setcookie("logged", "1", time() + 300, "/", $_SERVER['host'], false, false);
                http_response_code(205);
                return;
            }
        }
        http_response_code(401);
        return;
    }

    public function logout(): void
    {
        if ($this->isLogged()) {
            setcookie("logged", "0", time() + 300, "/", $_SERVER['host'], false, false);
            http_response_code(205);
            return;
        } else {
            http_response_code(500);
            return;
        }
    }
}
