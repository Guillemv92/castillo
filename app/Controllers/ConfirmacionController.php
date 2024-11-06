<?php

namespace App\Controllers;

use App\Models\Servicio;
use App\Models\Reserva;

class ConfirmacionController {
    public function mostrarConfirmacion() {

        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
        // Obtener datos de la reserva desde los parámetros de la URL
        $servicio = $_GET['servicio'] ?? '';
        $fechaEntrada = $_GET['fecha_entrada'] ?? 'N/A';
        $adultos = $_GET['adultos'] ?? 1;
        $fechaSalida = $_GET['fecha_salida'] ?? 'N/A';

        // Definir el ID del servicio en la base de datos según el tipo de servicio
        $idServicio = $this->obtenerIdServicio($servicio);

        // Usar el modelo Servicio para obtener el precio unitario
        $servicioModel = new Servicio();
        $precioUnitario = $servicioModel->obtenerPrecioServicio($idServicio);

        // Calcular el costo total
        $costoTotal = $precioUnitario * $adultos;

        // Pasar los datos a la vista de confirmación
        // Asegúrate de que las variables estén disponibles en la vista
        include __DIR__ . '/../Views/confirmacionReserva.php';
    }

    // Método para procesar la reserva al confirmar
    public function procesarReserva() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user'])) {
                header("Location: /login");
                exit();
            }
        

            // Obtener datos del formulario
            $servicio = $_POST['servicio'];
            $fechaEntrada = $_POST['fecha_entrada'];
            $fechaSalida = $_POST['fecha_salida'] ?? null; // Puede ser null si es "pasar el día"
            $adultos = $_POST['adultos'];
            $precioTotal = $_POST['precio_total'];

            // Obtener el ID del servicio
            $idServicio = $this->obtenerIdServicio($servicio);

            // Obtener el ID de la persona (usuario)
            $idPersona = $_SESSION['id_persona'];

            // Crear una instancia del modelo Reserva
            $reservaModel = new Reserva();

            // Preparar los datos para la reserva
            $estado = 1; // Puedes ajustar el estado según tu lógica (1: activo, etc.)

            // Datos del servicio a reservar
            $servicios = [
                [
                    'id_servicio' => $idServicio,
                    'cantidad' => $adultos,
                    'fecha_inicio' => $fechaEntrada,
                    'fecha_fin' => $fechaSalida ?? $fechaEntrada // Si no hay fecha de salida, usar fecha de entrada
                ]
            ];

            // No estamos reservando habitaciones en este caso
            $habitaciones = [];

            // Guardar la reserva y obtener el ID de la reserva creada
            try {
                $idReserva = $reservaModel->guardarReserva($idPersona, $estado, $servicios, $habitaciones);

                // Mostrar mensaje de éxito y redirigir
                echo "<script>alert('Reserva confirmada con éxito');</script>";
                echo "<script>window.location.href = '/';</script>";
                exit();
            } catch (\Exception $e) {
                // Manejo de errores
                echo "<script>alert('Ocurrió un error al confirmar la reserva: " . $e->getMessage() . "');</script>";
                echo "<script>window.location.href = '/confirmacionReserva';</script>";
                exit();
            }
        }
    }

    // Método auxiliar para definir el ID del servicio
    private function obtenerIdServicio($servicio) {
        switch ($servicio) {
            case 'camping':
                return 2;
            case 'pasar_el_dia':
                return 1;
            // Agregar más casos según los servicios
            default:
                return null;
        }
    }
}
