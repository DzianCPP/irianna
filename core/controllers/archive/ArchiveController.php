<?php

declare(strict_types=1);

namespace core\controllers\archive;

use core\Dto\archive\ArchiveFormDataDto;
use core\services\Archiver;
use core\views\archive\ArchiveView;
use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use Exception;

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
            ]
        ];

        $this->view->render("archive/form.html.twig", $data);
    }

    public function submit(): void
    {
        /** @var ArchiveFormDataDto */
        $formDataDto = $this->createFormDataDto();
        $archiver = new Archiver();
        
        try {
            $result = $archiver->archive($formDataDto);
        } catch (Exception $e) {
            $this->log($e->getMessage());

            $result = false;
        }

        $data = [
            'result' => $result === true
                ? 'Данные успешно перенесены в архив'
                : 'Во время архивации произошла ошибка',
            'title' => 'Архивация',
            'author' => 'IriANNA',
            'login' => $_COOKIE['login'],
        ];

        $this->setView(ArchiveView::class);

        $this->view->render('archive/archive_result.html.twig', $data);
    }

    private function createFormDataDto(): ArchiveFormDataDto
    {
        $formDataDto = new ArchiveFormDataDto($_POST);

        return $formDataDto;
    }

    public function new(): void
    {
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