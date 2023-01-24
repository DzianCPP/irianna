<?php

namespace core\controllers\contracts;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\services\IdGetter;
use core\views\contracts\ContractsView;
use core\models\contracts\ContractsModel;

class ContractsController extends BaseController implements ControllerInterface
{    
    public function new(): void
    {
        $this->setView(ContractsView::class);

        $data = [
            'login' => $_COOKIE['login'],
            'title' => 'Новый шаблон',
            'header' => 'Новый шаблон'
        ];

        $this->view->render("contracts/new.html.twig", $data);
    }

    public function edit(): void
    {
        $id = IdGetter::getId();
        $this->setModel(ContractsModel::class);
        $this->setView(ContractsView::class);

        $contract = $this->model->get(columnValue: ['column' => 'id', 'value' => $id])[0];
        $contract['html'] = htmlspecialchars_decode($contract['html'], ENT_QUOTES);
        $data = [
            'title' => 'Исправить шаблон договора',
            'header' => 'Исправить шаблон договора',
            'login' => $_COOKIE['login'],
            'contract' => $contract
        ];

        $this->view->render("contracts/edit.html.twig", $data);

    }

    public function create(): void
    {
        $this->setModel(ContractsModel::class);
        if (!$this->model->create()) {
            http_response_code(500);
            die();
        }

        http_response_code(200);
        return;
    }

    public function read(int $id = 0): void
    {
        $this->setModel(ContractsModel::class);
        $this->setView(ContractsView::class);

        $contracts = $this->model->get();

        $page = $this->getPage();
        $pages = (int)ceil(count($contracts) / self::PER_PAGE);

        $data = [
            'title' => 'Шаблоны документов',
            'header' => 'Шаблоны документов',
            'contracts' => $contracts,
            'login' => $_COOKIE['login'],
            'currentPage' => $page,
            'pages' => $pages
        ];

        $this->view->render("contracts/contracts.html.twig", $data);
    }

    public function update(int $id = 0): void
    {
        $this->setModel(COntractsModel::class);

        $newInfo = json_decode(file_get_contents("php://input"), true);
        
        if (!$this->model->update($newInfo)) {
            http_response_code(500);
            die();
        }

        return;
    }

    public function delete(int $id = 0): void
    {
        $this->setModel(ContractsModel::class);
        $ids = json_decode(file_get_contents("php://input"));
        if (!$this->model->delete(columnValues: ['column' => 'id', 'values' => $ids])) {
            http_response_code(500);
            die();
        }

        return;
    }
}