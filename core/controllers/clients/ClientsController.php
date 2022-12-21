<?php

namespace core\controllers\clients;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\views\clients\ClientsView;

class ClientsController extends BaseController implements ControllerInterface
{
    public function new(): void
    {
        $data = [
            'title' => 'Добавить клиента',
            'header' => 'Добавить клиента',
            'login' => $_COOKIE['login']
        ];

        $this->setView(ClientsView::class);
        $this->view->render("clients/new.html.twig", $data);
    }

    public function edit(): void
    {
        return;
    }

    public function create(): void
    {
        return;
    }

    public function read(int $id = 0): void
    {
        $data = [
            'title' => 'Клиенты',
            'header' => 'Клиенты',
            'login' => $_COOKIE['login'],
            'currentPage' => 1,
            'pages' => 1
        ];
        $this->setView(ClientsView::class);
        $this->view->render("clients/clients.html.twig", $data);
    }

    public function update(int $id = 0): void
    {
        return;
    }

    public function delete(int $id = 0): void
    {
        return;
    }
}
