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
            $precioUnitario = (int) $habitacion['precio']; // Asegurar que sea un entero
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
            $costoTotal = $precioUnitario * $dias; // Calcular como entero
        } else {
            // Si es otro tipo de servicio
            $idServicio = $this->obtenerIdServicio($servicio);
            $servicioModel = new Servicio();
            $precioUnitario = (int) $servicioModel->obtenerPrecioServicio($idServicio); // Asegurar que sea entero
            $costoTotal = $precioUnitario * $adultos;
        }
    
        include __DIR__ . '/../Views/confirmacionReserva.php';
    }
    

    // Método para procesar la reserva al confirmar
    public function procesarReserva()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['paymentId'])) {
            session_start();
            if (!isset($_SESSION['user'])) {
                header("Location: /login");
                exit();
            }
    
            // Recoger los datos de la reserva desde los parámetros GET
            $servicio = $_GET['servicio'] ?? null;
            $idHabitacion = $_GET['id_habitacion'] ?? null;
            $fechaEntrada = $_GET['fecha_entrada'] ?? null;
            $fechaSalida = $_GET['fecha_salida'] ?? null;
            $adultos = $_GET['adultos'] ?? null;
            $precioTotal = $_GET['precio_total'] ?? null;
    
            // Verificar que todos los datos necesarios están presentes
            if ($servicio && $fechaEntrada && $fechaSalida && $adultos && $precioTotal) {
                $idPersona = $_SESSION['user']['id'];
                $reservaModel = new Reserva();
                $estado = 1;
                $servicios = $habitaciones = [];
    
                if ($servicio === 'habitacion') {
                    $habitaciones[] = [
                        'id_habitacion' => $idHabitacion,
                        'fecha_inicio' => $fechaEntrada,
                        'fecha_fin' => $fechaSalida,
                    ];
                } else {
                    $idServicio = $this->obtenerIdServicio($servicio);
                    $servicios[] = [
                        'id_servicio' => $idServicio,
                        'cantidad' => $adultos,
                        'fecha_inicio' => $fechaEntrada,
                        'fecha_fin' => $fechaSalida,
                    ];
                }
    
                try {
                    $idReserva = $reservaModel->guardarReserva($idPersona, $estado, $servicios, $habitaciones);
                    echo "<script>alert('Reserva confirmada con éxito');</script>";
                    echo "<script>window.location.href = '/';</script>";
                    exit();
                } catch (\Exception $e) {
                    echo "<script>alert('Error al confirmar la reserva: " . $e->getMessage() . "');</script>";
                    echo "<script>window.location.href = '/confirmacionReserva';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Datos incompletos para la reserva.');</script>";
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
