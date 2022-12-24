<?php

namespace core\views\managers;

use core\views\ViewInterface;
use core\views\BaseView;

class ManagersView extends BaseView implements ViewInterface
{
    public function render(string $template, $data = NULL): void
    {
        if ($data !== NULL) {
            echo $this->twig->render($template, $data);
        } else {
            echo $this->twig->render($template);
        }
    }
}
