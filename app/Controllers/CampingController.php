<?php

namespace App\Controllers;

class CampingController {
    // Muestra el formulario de reserva para camping
    public function mostrarFormulario() {
        include_once __DIR__ . '/../Views/camping.php';
    }

    // Procesa los datos de reserva para camping
    public function procesarReserva() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Recoger los datos enviados desde el formulario
            $fechaEntrada = $_GET['fecha_entrada'];
            $fechaSalida = $_GET['fecha_salida'];
            $adultos = $_GET['adult'];

            // Redirigir a la vista de confirmación
            header("Location: /confirmacion?fecha_entrada=$fechaEntrada&fecha_salida=$fechaSalida&adult=$adultos");
            exit();
        }
    }
}
