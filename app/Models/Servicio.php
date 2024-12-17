<?php

namespace App\Models;

use Config\Database;
use PDO;

class Servicio {
    public function obtenerDisponibilidadServicio($idServicio, $fechaEntrada, $fechaSalida, $cantidadSolicitada) {
    $db = new Database();
    $conn = $db->getConnection();

    // Formatear fechas a 'Y-m-d' antes de usarlas en la consulta
    $fechaEntrada = DateTime::createFromFormat('d/m/Y', $fechaEntrada)->format('Y-m-d');
    $fechaSalida = DateTime::createFromFormat('d/m/Y', $fechaSalida)->format('Y-m-d');

    // Paso 1: Obtener la cantidad límite del servicio
    $queryCantidadLimite = "SELECT cantidad_limite 
                            FROM servicios 
                            WHERE id_servicio = :idServicio AND estado = 'A'";
    $stmtCantidadLimite = $conn->prepare($queryCantidadLimite);
    $stmtCantidadLimite->bindParam(':idServicio', $idServicio);
    $stmtCantidadLimite->execute();
    $cantidadLimite = $stmtCantidadLimite->fetchColumn();

    if ($cantidadLimite === false) {
        // Si no se encuentra el servicio o está inactivo, retorna false
        return false;
    }

    // Paso 2: Calcular la cantidad ya reservada en el rango de fechas
    $queryReservas = "SELECT COALESCE(SUM(rs.cantidad::int), 0) AS total_reservado
                      FROM reserva_servicio rs
                      JOIN reservas r ON r.id_reserva = rs.id_reserva
                      WHERE rs.id_servicio = :idServicio
                      AND (rs.fecha_inicio <= :fechaSalida AND rs.fecha_fin >= :fechaEntrada)";
    
    $stmtReservas = $conn->prepare($queryReservas);
    $stmtReservas->bindParam(':idServicio', $idServicio);
    $stmtReservas->bindParam(':fechaEntrada', $fechaEntrada);
    $stmtReservas->bindParam(':fechaSalida', $fechaSalida);
    $stmtReservas->execute();
    $totalReservado = $stmtReservas->fetchColumn();

    // Paso 3: Comparar la cantidad solicitada con la disponibilidad restante
    $disponible = $cantidadLimite - $totalReservado;
    return $cantidadSolicitada <= $disponible;
}

    // Obtiene el precio de un servicio según su ID
    public function obtenerInfoServicio($idServicio) {
        $db = new Database();
        $conn = $db->getConnection();
    
        $query = "SELECT nombre, precio, descripcion, imagen FROM servicios WHERE id_servicio = :idServicio AND estado = 'A'";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idServicio', $idServicio);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
