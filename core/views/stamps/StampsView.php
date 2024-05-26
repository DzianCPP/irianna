<?php

declare(strict_types=1);

namespace core\views\stamps;

use core\views\BaseView;

final class StampsView extends BaseView
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