<?php

namespace core\views\contracts;

use core\views\BaseView;

class ContractsView extends BaseView
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