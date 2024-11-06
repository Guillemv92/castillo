<?php

namespace App\Controllers;

use App\Models\Servicio;

class CampingController {
    public function mostrarFormulario() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
        
        include_once __DIR__ . '/../Views/camping.php';
    }

    public function procesarReserva() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fechaEntrada = $_POST['fecha_entrada'];
            $fechaSalida = $_POST['fecha_salida'];
            $adultos = $_POST['adult'];
            $action = $_POST['action'];

            // ID del servicio para camping (ajusta este valor según tu base de datos)
            $idServicioCamping = 2;

            // Crear una instancia de Servicio para verificar la disponibilidad
            $servicioModel = new Servicio();
            $disponible = $servicioModel->obtenerDisponibilidadServicio($idServicioCamping, $fechaEntrada, $fechaSalida, $adultos);

            if ($disponible) {
                if ($action === 'reservar') {
                    // Redirigir a la página de confirmación
                    header("Location: /confirmacionReserva?servicio=camping&fecha_entrada=$fechaEntrada&fecha_salida=$fechaSalida&adultos=$adultos");
                    exit();
                } elseif ($action === 'carrito') {
                    // Agregar al carrito
                    if (!isset($_SESSION['carrito'])) {
                        $_SESSION['carrito'] = [];
                    }

                    $_SESSION['carrito'][] = [
                        'servicio' => 'camping',
                        'fecha_entrada' => $fechaEntrada,
                        'fecha_salida' => $fechaSalida,
                        'adultos' => $adultos
                    ];

                    echo "<script>alert('Reserva de Camping agregada al carrito. Ir al carrito para confirmar la compra.');</script>";
                    echo "<script>window.location.href = '/camping';</script>";
                    exit();
                }
            } else {
                // Mostrar un mensaje de error si no hay disponibilidad
                echo "<script>alert('Lo sentimos, no hay disponibilidad suficiente para camping en las fechas seleccionadas.');</script>";
                echo "<script>window.location.href = '/camping';</script>";
                exit();
            }
        }
    }
}
