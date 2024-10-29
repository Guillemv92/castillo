<?php
// core/Model.php

require_once '../config/database.php';

class Model {
    protected $db;

    public function __construct() {
        // Usa la clase de conexión de config/database.php
        $conexion = new CConexion();
        $this->db = $conexion->getConnection();
    }

    // Métodos adicionales comunes a todos los modelos pueden ir aquí
}
