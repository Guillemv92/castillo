<?php

namespace App\Models;

use Config\Database;

class Resenha
{
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function guardarResenha($reservaId, $titulo, $calificacion, $descripcion)
    {
        $query = "INSERT INTO resenha (id_reserva, titulo, calificacion, descripcion, estado) 
                  VALUES (:id_reserva, :titulo, :calificacion, :descripcion, 1)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_reserva', $reservaId);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':calificacion', $calificacion);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->execute();
    }

    public function obtenerResenhas($idServicio = null, $idHabitacion = null)
{
    $query = "SELECT r.titulo, r.calificacion, r.descripcion 
              FROM resenha r
              INNER JOIN reservas res ON r.id_reserva = res.id_reserva ";

    // Si es un servicio general
    if ($idServicio) {
        $query .= "INNER JOIN reserva_servicio rs ON res.id_reserva = rs.id_reserva
                    WHERE rs.id_servicio = :id_servicio";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_servicio', $idServicio);

    // Si es una habitación específica
    } elseif ($idHabitacion) {
        $query .= "INNER JOIN reserva_habitacion rh ON res.id_reserva = rh.id_reserva
                    WHERE rh.id_habitacion = :id_habitacion";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_habitacion', $idHabitacion);
    } else {
        throw new \Exception("Debe proporcionar un idServicio o idHabitacion");
    }

    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
}
