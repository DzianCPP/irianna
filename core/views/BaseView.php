<?php

namespace core\views;

class BaseView
{
    protected string $templatePath;

    public function __construct()
    {
        $this->templatePath = "path";
    }
}
