<?php

declare(strict_types=1);

namespace core\controllers\archive;

use core\views\archive\ArchiveView;
use core\controllers\BaseController;
use core\controllers\ControllerInterface;

class ArchiveController extends BaseController implements ControllerInterface
{
    public function form(): void
    {
        $this->setView(ArchiveView::class);
        $data = [
            'title' => 'Архивация',
            'author' => 'IriANNA',
            'header' => 'Архивация',
            'login' => $_COOKIE['login'],
            'entities' => [
                'buses' => 'Автобусы',
                'hotels' => 'Гостиницы',
                'clients' => 'Клиенты',
                'tours' => 'Туры',
                'countries' => 'Страны',
                'resorts' => 'Курорты',
            ]
        ];

        $this->view->render("archive/form.html.twig", $data);
    }

    public function submit(): void
    {
    }

    public function new(): void{}
    public function edit(): void{}
    public function create(): void{}
    public function read(int $id = 0): void{}
    public function update(int $id = 0): void{}
    public function delete(int $id = 0): void{}
}