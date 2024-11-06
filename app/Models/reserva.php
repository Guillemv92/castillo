<?php

namespace App\Models;

use Config\Database;
use PDO;

class Reserva {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function guardarReserva($idPersona, $estado, $servicios, $habitaciones) {
        try {
            $this->conn->beginTransaction();

            // Insertar la reserva principal en la tabla reservas
            $queryReserva = "INSERT INTO reservas (id_persona, fecha_reserva, estado) VALUES (:idPersona, NOW(), :estado) RETURNING id_reserva";
            $stmtReserva = $this->conn->prepare($queryReserva);
            $stmtReserva->bindParam(':idPersona', $idPersona);
            $stmtReserva->bindParam(':estado', $estado);
            $stmtReserva->execute();
            $idReserva = $stmtReserva->fetchColumn();

            // Insertar servicios en la tabla reserva_servicio con fechas correspondientes
            foreach ($servicios as $servicio) {
                $queryReservaServicio = "INSERT INTO reserva_servicio (id_reserva, id_servicio, cantidad, fecha_inicio, fecha_fin) VALUES (:idReserva, :idServicio, :cantidad, :fechaInicio, :fechaFin)";
                $stmtReservaServicio = $this->conn->prepare($queryReservaServicio);
                $stmtReservaServicio->bindParam(':idReserva', $idReserva);
                $stmtReservaServicio->bindParam(':idServicio', $servicio['id_servicio']);
                $stmtReservaServicio->bindParam(':cantidad', $servicio['cantidad']);
                $stmtReservaServicio->bindParam(':fechaInicio', $servicio['fecha_inicio']);
                $stmtReservaServicio->bindParam(':fechaFin', $servicio['fecha_fin']);
                $stmtReservaServicio->execute();
            }

            // Si hay habitaciones, insertarlas en reserva_habitacion
            foreach ($habitaciones as $habitacion) {
                $queryReservaHabitacion = "INSERT INTO reserva_habitacion (id_reserva, id_habitacion, fecha_inicio, fecha_fin) VALUES (:idReserva, :idHabitacion, :fechaInicio, :fechaFin)";
                $stmtReservaHabitacion = $this->conn->prepare($queryReservaHabitacion);
                $stmtReservaHabitacion->bindParam(':idReserva', $idReserva);
                $stmtReservaHabitacion->bindParam(':idHabitacion', $habitacion['id_habitacion']);
                $stmtReservaHabitacion->bindParam(':fechaInicio', $habitacion['fecha_inicio']);
                $stmtReservaHabitacion->bindParam(':fechaFin', $habitacion['fecha_fin']);
                $stmtReservaHabitacion->execute();
            }

            $this->conn->commit();
            return $idReserva; // Retorna el ID de la reserva si todo fue exitoso

        } catch (\Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
}
