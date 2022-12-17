<?php

namespace core\controllers\hotels;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\models\resorts\ResortsModel;
use core\views\hotels\HotelsView;
use core\models\hotels\HotelsModel;

class HotelsController extends BaseController implements ControllerInterface
{
    public function new(string $hotelName = "", int $is_active = 0): void
    {
        $this->setView(HotelsView::class);
        $this->setModel(HotelsView::class);
        $resortsModel = new ResortsModel();
        $data = [
            'name' => $hotelName,
            'is_active' => $is_active,
            'resorts' => $resortsModel->get(),
            'title' => 'IriANNA',
            'author' => 'IriANNA',
            'header' => 'Добавить отель',
            'login' => $_COOKIE['login']
        ];

        $this->view->render("hotels/new.html.twig", $data);
    }
    public function edit(): void
    {
    }
    public function create(): void
    {
        $this->setModel(HotelsModel::class);
        $this->model->create();
    }
    public function read(int $id = 0): void
    {
        if (!$this->isLogged()) {
            header("Location: " . "/admin");
            exit;
        }

        $this->setModel(HotelsModel::class);
        $resortsModel = new ResortsModel();
        $hotels = $this->model->get();
        $this->setView(HotelsView::class);
        $page = $this->getPage();
        $pages = (int)ceil(count($hotels) / parent::PER_PAGE);
        if ($page) {
            $this->limitRange($hotels, $page);
        } else {
            $this->limitRange($hotels);
        }

        $data = [
            'hotels' => $hotels,
            'resorts' => $resortsModel->get(),
            'currentPage' => $page,
            'pages' => $pages,
            'title' => 'IriANNA',
            'author' => 'IriANNA',
            'login' => $_COOKIE['login'],
            'header' => 'Гостиницы'
        ];

        if ($page > $pages || $page < 1) {
            $this->notFound();
            return;
        }

        $this->view->render("hotels/hotels.html.twig", $data);
    }
    public function update(int $id = 0): void
    {
    }
    public function delete(int $id = 0): void
    {
    }
}