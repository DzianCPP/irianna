<?php

namespace core\application;

class Track
{
    private string $controller = '';
    private string $action = '';
    private string $method = '';
    private string $params = '';

    public function __construct(array $route)
    {
        $this->controller = $route['controller'];
        $this->action = $route['action'];
        $this->method = $route['method'];
        if (array_key_exists('params', $route)) {
            $this->params = $this->extractParam();
        }
    }

    public function getActionName(): string
    {
        return lcfirst($this->action);
    }

    public function getControllerName(): string
    {
        return $this->controller;
    }

    private function extractParam(): string
    {
        return filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_NUMBER_INT);
    }

    public function getParams(): string
    {
        return $this->params;
    }
}
