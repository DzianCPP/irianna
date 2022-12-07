<?php

namespace core\controllers;

class BaseController
{
    protected function setView(string $nameView): void
    {
        $this->view = new $nameView();
    }

    protected function setModel(string $nameModel): void
    {
        $this->users = new $nameModel();
    }
}
