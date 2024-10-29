<?php
// core/App.php

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Verifica si el controlador existe
        if (file_exists("../app/Controllers/{$url[0]}.php")) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once "../app/Controllers/{$this->controller}.php";
        $this->controller = new $this->controller;

        // Verifica si el método existe en el controlador
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Captura los parámetros restantes
        $this->params = $url ? array_values($url) : [];

        // Llama al controlador/método con los parámetros
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}