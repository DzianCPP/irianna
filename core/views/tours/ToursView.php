<?php

namespace core\views\tours;

use core\views\BaseView;
use core\views\ViewInterface;

class ToursView extends BaseView implements ViewInterface
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
