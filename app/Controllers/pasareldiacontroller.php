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

    public function agregarAlCarrito() {
        // Asegúrate de que la sesión está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Obtener datos de la reserva de pasar el día
        $fechaEntrada = $_POST['fecha_entrada'];
        $adultos = $_POST['adult'];
        
        // Crear un elemento de reserva
        $reserva = [
            'tipo' => 'Pasar el Día',
            'fecha_entrada' => $fechaEntrada,
            'adultos' => $adultos,
        ];
        
        // Iniciar el carrito si no existe y agregar el elemento
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        $_SESSION['carrito'][] = $reserva;
        
        // Redirigir al carrito
        echo "<script>
                alert('Reserva de Pasar el Día agregada al carrito. Ir al carrito para confirmar la compra.');
                window.location.href = '/carrito';
              </script>";
    }
    
}


?>