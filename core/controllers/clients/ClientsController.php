<?php

namespace core\controllers\clients;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\services\Paginator;
use core\views\clients\ClientsView;
use core\models\clients\ClientsModel;
use core\models\clients\helpers\ClientsHelper;
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
        $clients = $this->model->get();

        $page = Paginator::getPage();
        $pages = (int)ceil(count($clients) / parent::PER_PAGE);

        if ($page) {
            Paginator::limitRange($clients, self::PER_PAGE, $page);
        } else {
            Paginator::limitRange($clients, self::PER_PAGE);
        }

        $data = [
            'title' => 'Клиенты',
            'entity' => 'clients',
            'header' => 'Клиенты',
            'login' => $_COOKIE['login'],
            'currentPage' => $page,
            'pages' => $pages,
            'clients' => $clients
        ];

        $this->setView(ClientsView::class);
        $this->view->render("clients/clients.html.twig", $data);
    }

    public function update(int $id = 0): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $this->setModel(ClientsModel::class);
        if (!$this->model->update($data)) {
            http_response_code(500);
            die();
        }

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

    public function find(): void
    {
        $this->setModel(ClientsModel::class);
        $passport = json_decode(file_get_contents("php://input"), true);
        $client = $this->model->get(columnValue: ['column' => 'passport', 'value' => $passport])[0];
        echo (json_encode($client));
    }

    public function getLastClientId(): void
    {
        $this->setModel(ClientsModel::class);
        $id = $this->model->getLastClientId();
        echo json_encode($id);
    }

    public function updateSubClients(): void
    {
        $this->setModel(ClientsModel::class);
        if (!$this->model->updateSubClients(json_decode(file_get_contents("php://input"), true))) {
            http_response_code(500);
            die();
        }

        return;
    }
}
