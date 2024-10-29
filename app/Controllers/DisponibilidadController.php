<?php

namespace App\Controllers;

use App\Models\Habitacion;

class DisponibilidadController {
    public function verificarDisponibilidad() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Recoger datos del formulario
            $fechaEntrada = $_GET['fecha_entrada'];
            $fechaSalida = $_GET['fecha_salida'];
            $adultos = $_GET['adult'];

            // Crear instancia del modelo y obtener habitaciones disponibles
            $habitacionModel = new Habitacion();
            $habitacionesDisponibles = $habitacionModel->obtenerHabitacionesDisponibles($fechaEntrada, $fechaSalida, $adultos);

            // Pasar datos a la vista
            include_once __DIR__ . '/../Views/disponibilidad.php';
        }
    }
}
