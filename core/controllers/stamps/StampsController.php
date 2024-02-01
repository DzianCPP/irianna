<?php

declare(strict_types=1);

namespace core\controllers\stamps;

use core\controllers\ControllerInterface;
use core\controllers\BaseController;
use core\models\managers\ManagersModel;
use core\models\stamps\StampsModel;
use core\views\stamps\StampsView;

final class StampsController extends BaseController implements ControllerInterface
{
    public function new(): void
    {
        $managers = (new ManagersModel)->get();
        $this->setView(StampsView::class);
        $this->view->render('stamps/new.html.twig', [
            'managers' => $managers,
            'title' => 'Печать',
            'header' => 'Печать',
            'login' => $_COOKIE['login']
        ]);
    }

    public function edit(): void{}

    public function create(): void
    {
        $stampFile = $_FILES['stamp'] ?? false;

        if (!$stampFile) {
            http_response_code(500);
            $this->setContentTypeApplicationJsonHeader();
            echo json_encode([
                'status' => '500',
                'message' => 'Could not get file from form'
            ]);
        }


        $manager_id = $_POST['manager_id'];
        $uploadDir = BASE_PATH . "static/";
        $targetFile = $uploadDir . basename($stampFile['name']);
        $moveResult = move_uploaded_file($stampFile['tmp_name'], $targetFile);

        if (!$moveResult) {
            http_response_code(500);
            $this->setContentTypeApplicationJsonHeader();
            echo json_encode([
                'status' => '500',
                'message' => 'Could not move uploaded file'
            ]);

            return;
        }

        $this->setModel(StampsModel::class);

        if (
            !$this->model->create(
                [
                    'manager_id' => $manager_id,
                    'path' => $targetFile
                ]
            )
        ) {
            http_response_code(500);
            $this->setContentTypeApplicationJsonHeader();
            echo json_encode([
                'status' => '500',
                'message' => 'Could not insert stamp data to DB'
            ]);

            return;
        }

        return;
    }

    public function read(int $id = 0): void
    {

    }

    public function update(int $id = 0): void{}

    public function delete(int $id = 0): void{}

    private function setContentTypeApplicationJsonHeader(): void
    {
        header('Content-Type: application/json');
    }
}