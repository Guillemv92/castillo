<?php

namespace App\Controllers;

use App\Models\Servicio;
use App\Models\Reserva;
use App\Models\Habitacion;

class ConfirmacionController
{
    public function mostrarConfirmacion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
    
        // Obtener datos de la reserva desde la URL
        $servicio = $_GET['servicio'] ?? '';
        $fechaEntrada = $_GET['fecha_entrada'] ?? null;
        $fechaSalida = $_GET['fecha_salida'] ?? null;
        $adultos = $_GET['adultos'] ?? 1;
        $precioUnitario = 0;
        $costoTotal = 0;
        $nombreHabitacion = '';
    
        if ($servicio === 'habitacion') {
            $habitacionId = $_GET['id_habitacion'] ?? null;
            $habitacionModel = new Habitacion();
    
            // Obtener la información de la habitación
            $habitacion = $habitacionModel->obtenerInfoHabitacion($habitacionId);
            $precioUnitario = $habitacion['precio'];
            $nombreHabitacion = $habitacion['nombre'];
    
            // Convertir las fechas al formato 'Y-m-d'
            $fechaEntradaFormato = \DateTime::createFromFormat('d/m/Y', $fechaEntrada);
            $fechaSalidaFormato = \DateTime::createFromFormat('d/m/Y', $fechaSalida);
    
            if (!$fechaEntradaFormato || !$fechaSalidaFormato) {
                echo "<script>alert('Formato de fecha incorrecto.');</script>";
                echo "<script>window.location.href = '/';</script>";
                exit();
            }
    
            // Calcular la diferencia en días
            $dias = $fechaEntradaFormato->diff($fechaSalidaFormato)->days;
    
            // Asegúrate de que al menos sea una noche (1 día)
            $dias = max(1, $dias);
            $costoTotal = $precioUnitario * $dias;
        } else {
            // Si es otro tipo de servicio
            $idServicio = $this->obtenerIdServicio($servicio);
            $servicioModel = new Servicio();
            $precioUnitario = $servicioModel->obtenerPrecioServicio($idServicio);
            $costoTotal = $precioUnitario * $adultos;
        }
    
        include __DIR__ . '/../Views/confirmacionReserva.php';
    }
    

    // Método para procesar la reserva al confirmar
    public function procesarReserva()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (!isset($_SESSION['user'])) {
                header("Location: /login");
                exit();
            }

            // Recibir los datos del formulario
            $servicio = $_POST['servicio'] ?? null;
            $fechaEntrada = $_POST['fecha_entrada'] ?? null;
            $fechaSalida = $_POST['fecha_salida'] ?? null;
            $adultos = $_POST['adultos'] ?? null;
            $precioTotal = $_POST['precio_total'] ?? null;

            // Obtener el ID del servicio
            $idServicio = $this->obtenerIdServicio($servicio);

            // Obtener el ID de la persona (usuario autenticado)
            $idPersona = $_SESSION['user']['id'];

            // Crear una instancia del modelo Reserva
            $reservaModel = new Reserva();

            // Preparar los datos para la reserva
            $estado = 1; // Ajustar el estado según tu lógica

            // Datos del servicio a reservar
            $servicios = [
                [
                    'id_servicio' => $idServicio,
                    'cantidad' => $adultos,
                    'fecha_inicio' => $fechaEntrada,
                    'fecha_fin' => $fechaSalida ?? $fechaEntrada // Usar fecha de entrada si no hay fecha de salida
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
    private function obtenerIdServicio($servicio)
    {
        switch ($servicio) {
            case 'camping':
                return 2;
            case 'pasar_el_dia':
                return 1;
            default:
                return null;
        }
    }
}
