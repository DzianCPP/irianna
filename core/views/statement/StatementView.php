<?php

namespace core\views\statement;

use core\views\BaseView;
use core\views\ViewInterface;

class StatementView extends BaseView implements ViewInterface
{
    public function render(string $template, array $data = NULL): void
    {
        if ($data !== NULL) {
            echo $this->twig->render($template, $data);
        } else {
            echo $this->twig->render($template);
        }
    }
}