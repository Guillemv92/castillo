<?php

namespace App\Controllers;

use App\Models\Habitacion;

class DisponibilidadController {
    // Método para solicitudes normales
    public function verificarDisponibilidad() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $fechaEntrada = $_GET['fecha_entrada'];
            $fechaSalida = $_GET['fecha_salida'];
            $adultos = $_GET['adult'];

            $habitacionModel = new Habitacion();
            $habitacionesDisponibles = $habitacionModel->obtenerHabitacionesDisponibles($fechaEntrada, $fechaSalida, $adultos);

            include __DIR__ . '/../Views/disponibilidad.php';
        }
    }

    // Método específicamente para manejar AJAX
    public function verificarDisponibilidadAjax() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $fechaEntrada = $_GET['fecha_entrada'];
            $fechaSalida = $_GET['fecha_salida'];
            $adultos = $_GET['adult'];

            $habitacionModel = new Habitacion();
            $habitacionesDisponibles = $habitacionModel->obtenerHabitacionesDisponibles($fechaEntrada, $fechaSalida, $adultos);

            ob_start();
            include __DIR__ . '/../Views/partials/_habitaciones_disponibles.php';
            $habitacionesHtml = ob_get_clean();

            echo json_encode(['html' => $habitacionesHtml]);
            exit;
        }
    }
}
