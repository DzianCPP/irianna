<?php

namespace core\controllers\contracts;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\views\contracts\ContractsView;
use RtfHtmlPhp\Document;
use RtfHtmlPhp\Html\HtmlFormatter;

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

    }

    public function create(): void
    {
        if (isset($_FILES['file'])) {
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $new_name = time() . '.' . $ext;
            move_uploaded_file($_FILES['file']['tmp_name'], "../static/contracts/" . $new_name);

            $rtf = file_get_contents(BASE_PATH . "static/contracts/" . $new_name);
            $document = new Document($rtf);

            $formatter = new HtmlFormatter('UTF-8');

            $html = $formatter->Format($document);

            $data = [
                'file_source' => BASE_PATH . 'static/contracts/' . $new_name
            ];

            echo json_encode($data);
        }

        return;
    }

    public function read(int $id = 0): void
    {

    }

    public function update(int $id = 0): void
    {

    }

    public function delete(int $id = 0): void
    {

    }
}