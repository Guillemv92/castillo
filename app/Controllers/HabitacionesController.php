<?php

namespace App\Controllers;

class HabitacionesController {
    // Muestra el formulario para verificar disponibilidad de habitaciones
    public function mostrarFormulario() {
        include_once __DIR__ . '/../Views/habitaciones.php';
    }

    // Procesa los datos del formulario y redirige a la página de disponibilidad
    public function verificarDisponibilidad() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Recoger los datos enviados del formulario
            $fechaEntrada = $_GET['fecha_entrada'];
            $fechaSalida = $_GET['fecha_salida'];
            $adultos = $_GET['adult'];

            // Redirigir a la vista de disponibilidad con parámetros
            header("Location: /disponibilidad?fecha_entrada=$fechaEntrada&fecha_salida=$fechaSalida&adult=$adultos");
            exit();
        }
    }
}
