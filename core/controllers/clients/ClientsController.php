<?php

namespace core\controllers\clients;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\views\clients\ClientsView;
use core\models\clients\ClientsModel;
use core\services\IdGetter;

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
        $this->setModel(ClientsModel::class);
        $this->setView(ClientsView::class);

        $client = $this->model->get(columnValue: ['column' => 'id', 'value' => IdGetter::getId()])[0];

        $data = [
            'client' => $client,
            'sub_clients' => $this->model->getSubClients(columnValue: ['column' => 'main_client_id', 'value' => $client['id']]),
            'title' => "Изменить клиента",
            'login' => $_COOKIE['login'],
            'header' => "Изменить клиента"
        ];

        $this->view->render("clients/edit.html.twig", $data);
    }

    public function create(): void
    {
        $this->setModel(ClientsModel::class);
        if (!$this->model->create()) {
            http_response_code(500);
            die();
        }

        return;
    }

    public function read(int $id = 0): void
    {
        $this->setModel(ClientsModel::class);
        
        $data = [
            'title' => 'Клиенты',
            'header' => 'Клиенты',
            'login' => $_COOKIE['login'],
            'currentPage' => 1,
            'pages' => 1,
            'clients' => $this->model->get()
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
        $this->setModel(ClientsModel::class);

        $ids = json_decode(file_get_contents("php://input"), true);
        if (!$this->model->delete(columnValues: ['column' => 'id', 'values' => $ids])) {
            http_response_code(500);
            die();
        }

        return;
    }
}
