<?php

namespace core\views;

use Exception;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class BaseView
{
    protected string $templatePath;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(TEMPLATES_PATH);
        $this->twig = new Environment($this->loader, [
            'debug' => false,
            'charset' => 'UTF-8',
            'strict_variable' => false,
            'optimizations' => -1,
            'auto_reload' => true,
            'cache' => CACHE_PATH
        ]);
    }
}
