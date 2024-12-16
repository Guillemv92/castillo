<?php

namespace App\Controllers;

use App\Models\Servicio;
use App\Models\Reserva;
use App\Models\Habitacion;
use App\Helpers\EmailHelper;

class ConfirmacionController
{
    public function mostrarConfirmacion()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Obtener datos de la reserva desde la URL
    $servicio = $_GET['servicio'] ?? '';
    $fechaEntrada = $_GET['fecha_entrada'] ?? null;
    $fechaSalida = $_GET['fecha_salida'] ?? null;
    $adultos = $_GET['adultos'] ?? 1;
    $precioUnitario = 0;
    $costoTotal = 0;
    $nombre = '';
    $descripcion = '';
    $imagen = '';
    $cotizacionDolar = 7300; // Valor por defecto
    $resenhas = []; // Inicializamos el array de reseñas

    try {
        // Llamar a la función para obtener la cotización del dólar
        $cotizacionDolar = $this->obtenerCotizacionDolar();
    } catch (\Exception $e) {
        // Si falla la cotización, usar un valor predeterminado
        echo "<script>alert('No se pudo obtener la cotización actual del dólar, usando valor predeterminado.');</script>";
    }

    if ($servicio === 'habitacion') {
        $habitacionId = $_GET['id_habitacion'] ?? null;
        $habitacionModel = new Habitacion();

        // Obtener la información de la habitación
        $habitacion = $habitacionModel->obtenerInfoHabitacion($habitacionId);
        $precioUnitario = (int) $habitacion['precio'];
        $nombre = $habitacion['nombre'];
        $descripcion = $habitacion['descripcion'];
        $imagen = $habitacion['imagen'];

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

        // Obtener las reseñas de la habitación
        $resenhaModel = new \App\Models\Resenha();
        $resenhas = $resenhaModel->obtenerResenhas(null, $habitacionId); // Pasamos el idHabitacion
    } else {
        // Si es otro tipo de servicio
        $idServicio = $this->obtenerIdServicio($servicio);
        $servicioModel = new Servicio();

        // Obtener la información del servicio
        $detalleServicio = $servicioModel->obtenerInfoServicio($idServicio);
        $precioUnitario = (int) $detalleServicio['precio'];
        $nombre = $detalleServicio['nombre'];
        $descripcion = $detalleServicio['descripcion'];
        $imagen = $detalleServicio['imagen'];

        if ($servicio === 'camping') {
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
            $costoTotal = $precioUnitario * $adultos * $dias;
        } else {
            // Otros servicios (como pasar el día)
            $costoTotal = $precioUnitario * $adultos;
        }

        // Obtener las reseñas del servicio
        $resenhaModel = new \App\Models\Resenha();
        $resenhas = $resenhaModel->obtenerResenhas($idServicio, null); // Pasamos el idServicio
    }

    // Convertir el precio a dólares usando la cotización obtenida
    $precioEnDolares = round($costoTotal / $cotizacionDolar, 2);

    $_SESSION['reserva'] = [
        'servicio' => $servicio,
        'id_habitacion' => $habitacionId ?? null,
        'fecha_entrada' => $fechaEntrada,
        'fecha_salida' => $fechaSalida,
        'adultos' => $adultos,
        'precio_total' => $costoTotal,
    ];

    // Incluir la vista de confirmación con los datos necesarios
    include __DIR__ . '/../Views/confirmacionReserva.php';
}

    public function obtenerCotizacionDolar()
    {
        $apiKey = "1a1a14c6b2c9070d6bc7a496"; // Coloca tu API Key
        $endpoint = "https://api.exchangerate-api.com/v4/latest/USD"; // Reemplaza con la URL de tu API
        $response = file_get_contents($endpoint);
        $data = json_decode($response, true);

        if (isset($data['rates']['PYG'])) {
            return $data['rates']['PYG'];
        } else {
            throw new \Exception("No se pudo obtener la cotización del dólar.");
        }
    }

    // Método para procesar la reserva al confirmar
    public function procesarReserva()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['paymentId'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['user'])) {
                header("Location: /login");
                exit();
            }

            // Recuperar datos de la reserva desde la sesión
            if (!isset($_SESSION['reserva'])) {
                error_log('No se encontraron datos de la reserva en la sesión.');
                echo "<script>alert('No se encontraron datos de la reserva.');</script>";
                echo "<script>window.location.href = '/';</script>";
                exit();
            }

            $reserva = $_SESSION['reserva'];
            $servicio = $reserva['servicio'];
            $idHabitacion = $reserva['id_habitacion'];
            $fechaEntrada = $reserva['fecha_entrada'];
            $fechaSalida = $reserva['fecha_salida'];
            $adultos = $reserva['adultos'];
            $precioTotal = $reserva['precio_total'];
            $paymentId = $_GET['paymentId'];

            try {
                $idPersona = $_SESSION['user']['id'];
                $reservaModel = new Reserva();
                $estado = 1;
                $servicios = $habitaciones = [];

                // Ajustar habitaciones y servicios
                if ($servicio === 'habitacion') {
                    $habitacionModel = new Habitacion();
                    $habitacion = $habitacionModel->obtenerInfoHabitacion($idHabitacion); // Obtener detalles de la habitación
                    $habitaciones[] = [
                        'id_habitacion' => $idHabitacion,
                        'fecha_inicio' => $fechaEntrada,
                        'fecha_fin' => $fechaSalida,
                    ];
                    $nombreServicio = "Habitación: " . $habitacion['nombre']; // Asigna el nombre de la habitación
                } else {
                    $idServicio = $this->obtenerIdServicio($servicio);
                    $servicios[] = [
                        'id_servicio' => $idServicio,
                        'cantidad' => $adultos,
                        'fecha_inicio' => $fechaEntrada,
                        'fecha_fin' => $fechaSalida,
                    ];
                    $nombreServicio = ucfirst(str_replace('_', ' ', $servicio)); // Asigna un nombre genérico
                }

                // Guardar la reserva
                $idReserva = $reservaModel->guardarReserva($idPersona, $estado, $servicios, $habitaciones);

                // Guardar el pago
                $reservaModel->guardarPago($idReserva, $paymentId, $precioTotal, 1);

                // Preparar detalles de la reserva para el correo
                $emailDestino = $_SESSION['user']['email'];
                $nombreCliente = $_SESSION['user']['nombre'];
                $detalleReserva = [
                    'servicio' => $servicio === 'habitacion' ? $habitacion['nombre'] : ucfirst(str_replace('_', ' ', $servicio)),
                    'fecha_entrada' => $fechaEntrada,
                    'fecha_salida' => $fechaSalida,
                    'adultos' => $adultos,
                    'precio_total' => number_format($precioTotal, 0, ',', '.') // Aplica formato aquí
                ];

                // Enviar el correo
                EmailHelper::enviarCorreoReserva($emailDestino, $nombreCliente, $detalleReserva, $idReserva);

                // Limpiar la sesión de reserva
                unset($_SESSION['reserva']);

                // Redirigir al inicio
                header("Location: /");
                exit();
            } catch (\Exception $e) {
                error_log('Error al confirmar la reserva: ' . $e->getMessage());
                echo "<script>alert('Error al confirmar la reserva: " . $e->getMessage() . "');</script>";
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
