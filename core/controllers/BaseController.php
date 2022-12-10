<?php

namespace core\controllers;

class BaseController
{
    protected $view;
    protected $model;

    protected function setView(string $nameView): void
    {
        $this->view = new $nameView();
    }

    protected function setModel(string $nameModel): void
    {
        $this->model = new $nameModel();
    }

    protected function isLogged(): bool
    {
        if (isset($_COOKIE['logged']) && $_COOKIE['logged'] === "1") {
            return true;
        }

        return false;
    }
}
