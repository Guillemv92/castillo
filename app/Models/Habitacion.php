<?php

namespace App\Models;

use Config\Database;
use PDO;

class Habitacion {
    public function obtenerHabitacionesDisponibles($fechaEntrada, $fechaSalida, $adultos) {
        $db = new Database();
        $conn = $db->getConnection();

        // Consulta para seleccionar habitaciones que no están reservadas en el rango de fechas solicitado
        $query = "SELECT h.* FROM habitaciones h
                  WHERE h.id_habitacion NOT IN (
                      SELECT rh.id_habitacion 
                      FROM reserva_habitacion rh
                      JOIN reservas r ON r.id_reserva = rh.id_reserva
                      WHERE (r.fecha_inicio <= :fechaSalida AND r.fecha_fin >= :fechaEntrada)
                  ) AND h.capacidad >= :adultos";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fechaEntrada', $fechaEntrada);
        $stmt->bindParam(':fechaSalida', $fechaSalida);
        $stmt->bindParam(':adultos', $adultos);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}