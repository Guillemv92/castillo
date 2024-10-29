<?php
// core/Controller.php

class Controller {
    // Método para cargar vistas
    public function view($view, $data = []) {
        // Extrae los datos como variables
        extract($data);

        // Carga la vista solicitada
        require_once "../app/Views/{$view}.php";
    }

    // Método para cargar modelos
    public function model($model) {
        require_once "../app/Models/{$model}.php";
        return new $model();
    }
}
