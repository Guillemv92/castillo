<?php

namespace App\Controllers;

use App\Models\Reserva;

class PasareldiaController {
    public function mostrarFormulario() {
        // Cargar la vista del formulario
        include_once __DIR__ . "/../Views/pasareldia.php";
    }

    public function procesarReserva() {
        // Aquí puedes procesar la reserva usando el modelo Reserva
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crear una instancia de Reserva y guardar los datos en la base de datos
            $reserva = new Reserva();
            $reserva->fechaEntrada = $_POST['fecha_entrada'];
            $reserva->adultos = $_POST['adult'];
            $reserva->guardar();
            
            // Redirigir a una página de confirmación o mostrar un mensaje
            header("Location: confirmacion.php");
            exit();
        }
    }
}


?>