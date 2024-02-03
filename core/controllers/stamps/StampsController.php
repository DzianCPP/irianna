<?php

declare(strict_types=1);

namespace core\controllers\stamps;

use core\controllers\ControllerInterface;
use core\controllers\BaseController;
use core\models\managers\ManagersModel;
use core\models\stamps\StampsModel;
use core\views\stamps\StampsView;
use core\services\Paginator;
use core\controllers\AppController;
use core\services\IdGetter;

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
        $uploadDir = BASE_PATH . "public_html/assets/images/uploadedStamps/";

        if (!is_dir($uploadDir)) {
            $result = mkdir(
                directory: $uploadDir,
                permissions: 0777,
                recursive: true
            );

            if (!$result) {
                echo "failed to create dir";
            }
        }

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
        $this->setModel(StampsModel::class);
        $stamps = $this->model->get();
        $page = Paginator::getPage();
        $pages = (int) ceil(count($stamps) / self::PER_PAGE);
        if ($page) {
            Paginator::limitRange($stamps, self::PER_PAGE, $page);
        } else {
            Paginator::limitRange($stamps, self::PER_PAGE);
        }

        $this->normalizeStampPath($stamps);

        $this->addManagerNameToStamp($stamps);

        $data = [
            'stamps' => $stamps,
            'entity' => 'stamps',
            'currentPage' => $page,
            'pages' => $pages,
            'countStamps' => count($stamps),
            'title' => 'IriANNA',
            'author' => 'IriANNA',
            'header' => 'Страны',
            'login' => $_COOKIE['login']
        ];

        $this->setView(StampsView::class);
        if (count($stamps) === 0) {
            $this->view->render("stamps/stamps.html.twig", $data);

            return;
        }

        if ($page > $pages || $page < 1) {
            $appController = new AppController();
            $appController->notFound();

            return;
        }

        $this->view->render("stamps/stamps.html.twig", $data);
    }

    public function update(int $id = 0): void{}

    public function delete(int $id = 0): void
    {
        $this->setModel(StampsModel::class);

        if (!$id) {
            $id = IdGetter::getId();
        }

        if (!$this->model->delete(['column' => 'id', 'value' => $id])) {
            echo "Could not delete stamp $id";
        }
    }

    private function setContentTypeApplicationJsonHeader(): void
    {
        header('Content-Type: application/json');
    }

    private function normalizeStampPath(array &$stamps = []): void
    {
        foreach ($stamps as &$stamp) {
            $assetsPosition = strpos(
                haystack: $stamp['path'],
                needle: 'assets',
                offset: 0
            );

            $stamp['path'] = substr(
                string: $stamp['path'],
                offset: $assetsPosition ?? 0,
                length: null
            );
        }
    }

    private function addManagerNameToStamp(array &$stamps = []): void
    {
        $managersModel = new ManagersModel();
        foreach ($stamps as &$stamp) {
            $stamp['manager'] = $managersModel->get(
                [
                    'column' => 'id',
                    'value' => $stamp['manager_id']
                ]
            )[0]['name'];
        }
    }
}