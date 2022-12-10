<?php

namespace core\controllers\login;

use core\controllers\BaseController;
use core\views\login\LoginView;
use core\models\admins\AdminsModel;
use core\controllers\admins\AdminsController;

class LoginController extends BaseController
{
    private AdminsController $adminsController;

    public function index(): void
    {
        if (!$this->isLogged()) {
            $this->setView(LoginView::class);
            $data = ["author" => "IriAnna", "title" => "IriANNA", "message" => "Войти в систему"];
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
                setcookie("logged", "1", time() + 28800, "/");
                $adminsController = new AdminsController();
                $adminsController->setPrivilege($admin);
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
            setcookie("logged", "0", time() + 300, "/");
            http_response_code(205);
            return;
        } else {
            http_response_code(500);
            return;
        }
    }
}
