<?php

namespace core\views;

interface ViewInterface
{
    public function render(string $template): void;
}
