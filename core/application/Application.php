<?php

namespace core\application;

use core\controllers\login\LoginController;
use core\services\PrivilegesChecker;
use core\services\LoginChecker;
use core\views\AppView;

class Application
{
    private Router $router;
    private PrivilegesChecker $privilegesChecker;
    private LoginChecker $loginChecker;

    public function __construct()
    {
        $this->privilegesChecker = new PrivilegesChecker();
        $this->loginChecker = new LoginChecker();
    }

    public function run(): void
    {
        $this->router = new Router();
        $track = $this->router->getTrack();

        $controllerName = $track->getControllerName();
        $controllerObject = new $controllerName;
        $actionName = $track->getActionName();

        if ($actionName == 'login' || $actionName == 'index' || $actionName == 'logout') {
            $controllerObject->$actionName();
            die();
        }

        if ($this->loginChecker->isLogged()) {

            if ($this->checkAccessRights() == 0) {
                $this->accessDenied();
            }

            if ($actionName == 'admins' && $this->checkAccessRights() == 1) {
                $this->accessDenied();
            }

            if ($this->checkAccessRights() == 1) {
                $controllerObject->$actionName();
            }

            if ($this->checkAccessRights() == 2) {
                $controllerObject->$actionName();
            }
        } else {
            $this->loginPage();
        }
    }

    private function accessDenied(): void
    {
        $view = new AppView();

        $data = [
            'title' => 'Доступ запрещен',
            'author' => 'Author: DzianCPP',
            'message' => '401: Доступ запрещен. Попросите главного администратора выделить права к ресурсу'
        ];

        $view->render("accessDenied/401.html.twig", $data);
        http_response_code(401);
        die();
    }

    private function checkAccessRights(): int
    {
        $privileges = $this->privilegesChecker->getPrivileges();

        if ($privileges == 0) {
            return 0;
        }

        if ($privileges == 1) {
            return 1;
        }

        return 2;
    }

    private function loginPage(): void
    {
        header('Location: /login');
        die();
    }
}