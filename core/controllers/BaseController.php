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
        $this->users = new $nameModel();
    }
}
