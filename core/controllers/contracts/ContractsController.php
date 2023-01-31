<?php

namespace core\controllers\contracts;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\services\IdGetter;
use core\services\Paginator;
use core\views\contracts\ContractsView;
use core\models\contracts\ContractsModel;

class ContractsController extends BaseController implements ControllerInterface
{
    public function new (): void
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
        $document_name = $contract['name'];
        $document_id = $contract['id'];
        $document_label = $contract['label'];
        $contract = $contract['html'];

        $fileName = 'contract.html.twig';
        $contractFileName = 'core/views/templates/components/' . $fileName;
        $contract = '{% block contract %}' . $contract . '{% endblock %}';

        $fp = fopen(BASE_PATH . $contractFileName, 'w');
        fwrite($fp, $contract, strlen($contract));
        fclose($fp);

        $data = [
            'title' => 'Исправить шаблон договора',
            'header' => 'Исправить шаблон договора',
            'login' => $_COOKIE['login'],
            'document_id' => $document_id,
            'document_name' => $document_name,
            'document_label' => $document_label
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

        $page = Paginator::getPage();
        $pages = (int)ceil(count($contracts) / parent::PER_PAGE);

        if ($page) {
            Paginator::limitRange($contracts, self::PER_PAGE, $page);
        } else {
            Paginator::limitRange($contracts, self::PER_PAGE);
        }

        $data = [
            'title' => 'Шаблоны документов',
            'entity' => 'contracts',
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
        $this->setModel(ContractsModel::class);

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

    public function addLabel(): void
    {
        $this->setModel(ContractsModel::class);
        $lastDocument = $this->model->getLastDocument();

        $label = json_decode(file_get_contents("php://input"), true)['label'];

        $lastDocument['label'] = $label;

        if (
            !$this->model->update(
            newInfo: [
                    'id' => $lastDocument['id'],
                    'name' => $lastDocument['name'],
                    'label' => $lastDocument['label'],
                    'html' => $lastDocument['html']
                ]
            )
        ) {
            http_response_code(500);
            die();
        }

        http_response_code(200);
    }
}