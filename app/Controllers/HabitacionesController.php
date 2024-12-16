<?php

namespace App\Controllers;


class HabitacionesController {
    // Muestra el formulario para verificar disponibilidad de habitaciones
    public function mostrarFormulario() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
        include_once __DIR__ . '/../Views/habitaciones.php';
    }


    public function agregarAlCarrito() {
        // Obtener datos de la reserva de habitación
        $fechaEntrada = $_POST['fecha_entrada'];
        $fechaSalida = $_POST['fecha_salida'];
        $adultos = $_POST['adult'];
        $habitacion = $_POST['habitacion']; // Puedes obtener esto de un formulario de reserva de habitaciones

        // Crear un elemento de reserva para la habitación
        $reserva = [
            'tipo' => 'Habitación',
            'habitacion' => $habitacion,
            'fecha_entrada' => $fechaEntrada,
            'fecha_salida' => $fechaSalida,
            'adultos' => $adultos,
        ];

        // Iniciar el carrito si no existe y agregar el elemento
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        $_SESSION['carrito'][] = $reserva;

        // Redirigir o mostrar un mensaje de éxito
        echo "<script>alert('Reserva de Habitación agregada al carrito. Ir al carrito para confirmar la compra.');</script>";
        echo "<script>window.location.href = '/habitaciones';</script>";
    }

}
