<?php

namespace App\Models;

use Config\Database;
use PDO;

class Habitacion {
    public function obtenerHabitacionesDisponibles($fechaEntrada, $fechaSalida, $adultos) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT h.*, h.precio 
                  FROM habitaciones h
                  WHERE h.id_habitacion NOT IN (
                      SELECT rh.id_habitacion 
                      FROM reserva_habitacion rh
                      JOIN reservas r ON r.id_reserva = rh.id_reserva
                      WHERE (rh.fecha_inicio <= :fechaSalida AND rh.fecha_fin >= :fechaEntrada)
                  ) AND h.capacidad >= :adultos";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fechaEntrada', $fechaEntrada);
        $stmt->bindParam(':fechaSalida', $fechaSalida);
        $stmt->bindParam(':adultos', $adultos);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerInfoHabitacion($habitacionId) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT nombre, precio FROM habitaciones WHERE id_habitacion = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $habitacionId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
