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
        $habitacionId = $_POST['id_habitacion'] ?? null;  // Recibimos el ID de la habitación

        // Obtener el ID de la persona (usuario autenticado)
        $idPersona = $_SESSION['user']['id'];
        $reservaModel = new Reserva();
        $estado = 1; // Estado de la reserva

        try {
            // Verificar si es una habitación o un servicio (pasar el día/camping)
            if ($servicio === 'habitacion' && $habitacionId) {
                // Preparar la reserva para habitaciones
                $habitaciones = [
                    [
                        'id_habitacion' => $habitacionId,
                        'fecha_inicio' => $fechaEntrada,
                        'fecha_fin' => $fechaSalida,
                    ]
                ];
                $servicios = []; // No hay servicios adicionales

                // Guardar la reserva con habitación
                $idReserva = $reservaModel->guardarReserva($idPersona, $estado, $servicios, $habitaciones);
            } else {
                // Preparar la reserva para otros servicios
                $idServicio = $this->obtenerIdServicio($servicio);
                $servicios = [
                    [
                        'id_servicio' => $idServicio,
                        'cantidad' => $adultos,
                        'fecha_inicio' => $fechaEntrada,
                        'fecha_fin' => $fechaSalida ?? $fechaEntrada
                    ]
                ];
                $habitaciones = []; // No hay habitaciones adicionales

                // Guardar la reserva con servicio
                $idReserva = $reservaModel->guardarReserva($idPersona, $estado, $servicios, $habitaciones);
            }

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
