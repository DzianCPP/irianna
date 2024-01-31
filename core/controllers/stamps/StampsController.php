<?php

declare(strict_types=1);

namespace core\controllers\stamps;

use core\controllers\ControllerInterface;
use core\controllers\BaseController;
use core\models\managers\ManagersModel;
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

    public function create(): void{}

    public function read(int $id = 0): void
    {

    }

    public function update(int $id = 0): void{}

    public function delete(int $id = 0): void{}
}