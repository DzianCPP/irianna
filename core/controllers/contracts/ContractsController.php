<?php

namespace core\controllers\contracts;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\views\contracts\ContractsView;

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