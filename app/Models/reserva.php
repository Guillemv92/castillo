<?php

namespace App\Models;

use Config\Database;
use PDO;

class Reserva {
    public $fechaEntrada;
    public $adultos;

    public function guardar() {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "INSERT INTO reservas (fecha_entrada, adultos) VALUES (:fecha_entrada, :adultos)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":fecha_entrada", $this->fechaEntrada);
        $stmt->bindParam(":adultos", $this->adultos);

        return $stmt->execute();
    }
}
