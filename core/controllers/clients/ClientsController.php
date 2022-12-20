<?php

namespace core\controllers\clients;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\views\clients\ClientsView;

class ClientsController extends BaseController implements ControllerInterface
{
    public function new(): void
    {
        $this->setView(ClientsView::class);
        $this->view->render("clients/new.html.twig");
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
        $this->setView(ClientsView::class);
        $this->view->render("clients/clients.html.twig");
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
