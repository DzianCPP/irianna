<?php

namespace core\controllers\hotels;

use core\controllers\BaseController;
use core\controllers\ControllerInterface;
use core\models\resorts\ResortsModel;
use core\services\Paginator;
use core\views\hotels\HotelsView;
use core\models\hotels\HotelsModel;
use core\services\IdGetter;

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
            'header' => 'Добавить гостиницу',
            'login' => $_COOKIE['login']
        ];

        $this->view->render("hotels/new.html.twig", $data);
    }

    public function edit(): void
    {
        $this->setModel(HotelsModel::class);
        $this->setView(HotelsView::class);
        $id = IdGetter::getId();

        $resorts = new ResortsModel();

        $data = [
            'hotel' => $this->model->get(columnValue: ['column' => "id", 'value' => $id])[0],
            'title' => "Исправить гостиницу",
            'header' => "Изменить гостиницу",
            'login' => $_COOKIE['login'],
            'resorts' => $resorts->get()
        ];

        $this->view->render("hotels/edit.html.twig", $data);
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
        $page = Paginator::getPage();
        $pages = (int)ceil(count($hotels) / parent::PER_PAGE);

        if ($page) {
            Paginator::limitRange($hotels, self::PER_PAGE, $page);
        } else {
            Paginator::limitRange($hotels, self::PER_PAGE);
        }

        $data = [
            'hotels' => $hotels,
            'entity' => 'hotels',
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
        $hotel = json_decode(file_get_contents("php://input"), true);
        $this->setModel(HotelsModel::class);
        $this->model->update($hotel);
    }

    public function delete(int $id = 0): void
    {
        $ids = json_decode(file_get_contents("php://input"), true);
        if (count($ids) < 1) {
            return;
        }

        $this->setModel(HotelsModel::class);
        if (!$this->model->delete([
            'column' => 'id',
            'values' => $ids
        ])) {
            http_response_code(500);
        };
    }
}
