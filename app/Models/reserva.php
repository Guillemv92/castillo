<?php

namespace App\Models;

use Config\Database;
use PDO;

class Reserva
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function guardarReserva($idPersona, $estado, $servicios, $habitaciones)
    {
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

    public function guardarPago($idReserva, $paymentId, $montoTotal, $formaPago)
    {
        try {
            $query = "INSERT INTO pago (id_reserva, paypal_order_id, monto_pagado, forma_pago, fecha, estado_pago)
                  VALUES (:idReserva, :paypalOrderId, :montoTotal, :formaPago, NOW(), 'COMPLETADO')";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':idReserva', $idReserva);
            $stmt->bindParam(':paypalOrderId', $paymentId);
            $stmt->bindParam(':montoTotal', $montoTotal);
            $stmt->bindParam(':formaPago', $formaPago); // Ahora será un entero
            $stmt->execute();
        } catch (\Exception $e) {
            throw new \Exception('Error al guardar el pago: ' . $e->getMessage());
        }
    }

    public function obtenerReservasPorUsuario($idUsuario)
    {
        $query = "
        SELECT 
            r.id_reserva,
            CASE
                WHEN h.nombre IS NOT NULL THEN h.nombre
                ELSE s.nombre
            END AS nombre_servicio,
            COALESCE(rh.fecha_inicio, rs.fecha_inicio) AS fecha_inicio,
            COALESCE(rh.fecha_fin, rs.fecha_fin) AS fecha_fin,
            COALESCE(CAST(rs.cantidad AS INTEGER), 1) AS adultos,
            COALESCE(rs.id_servicio, NULL) AS id_servicio,
            r.estado
        FROM reservas r
        LEFT JOIN reserva_habitacion rh ON r.id_reserva = rh.id_reserva
        LEFT JOIN habitaciones h ON rh.id_habitacion = h.id_habitacion
        LEFT JOIN reserva_servicio rs ON r.id_reserva = rs.id_reserva
        LEFT JOIN servicios s ON rs.id_servicio = s.id_servicio
        WHERE r.id_persona = :idUsuario
          AND r.estado = 1 
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function cancelarReserva($idReserva)
    {
        $query = "UPDATE reservas SET estado = 0 WHERE id_reserva = :idReserva";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idReserva', $idReserva, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function editarReserva($idReserva, $fechaInicio, $fechaFin, $adultos)
    {
        $query = "
        UPDATE reserva_servicio
        SET fecha_inicio = :fechaInicio, 
            fecha_fin = :fechaFin, 
            cantidad = :adultos
        WHERE id_reserva = :idReserva";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idReserva', $idReserva, PDO::PARAM_INT);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->bindParam(':adultos', $adultos, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function obtenerReservaPorId($idReserva)
    {
        $query = "
        SELECT 
            r.id_reserva,
            r.id_persona,
            r.fecha_reserva,
            r.estado,
            COALESCE(rs.fecha_inicio, rh.fecha_inicio) AS fecha_inicio,
            COALESCE(rs.fecha_fin, rh.fecha_fin) AS fecha_fin
        FROM reservas r
        LEFT JOIN reserva_servicio rs ON r.id_reserva = rs.id_reserva
        LEFT JOIN reserva_habitacion rh ON r.id_reserva = rh.id_reserva
        WHERE r.id_reserva = :idReserva
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idReserva', $idReserva);
        $stmt->execute();

        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("Resultado de la consulta: " . print_r($reserva, true));
        return $reserva;
    }
}
