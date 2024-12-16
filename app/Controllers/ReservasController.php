<?php

namespace App\Controllers;

use App\Models\Reserva;

class ReservasController
{
    // Muestra todas las reservas activas del usuario
    public function mostrarMisReservas()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user'])) {
        header("Location: /login");
        exit();
    }

    $idUsuario = $_SESSION['user']['id'];
    $reservaModel = new Reserva();
    $reservas = $reservaModel->obtenerReservasPorUsuario($idUsuario);

    // Ajustar datos para "pasar el día"
    foreach ($reservas as &$reserva) {
        if ($reserva['id_servicio'] == 1) { // ID del servicio "pasar el día"
            $reserva['fecha_fin'] = $reserva['fecha_inicio']; // Misma fecha para inicio y fin
        }
    }

    // Incluir la vista de mis reservas
    include __DIR__ . '/../Views/misReservas.php';
}
    // Cancela una reserva específica
    public function cancelarReserva()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['user'])) {
                header("Location: /login");
                exit();
            }

            $idReserva = $_GET['id'];
            $reservaModel = new Reserva();

            try {
                $reservaModel->cancelarReserva($idReserva);
                echo "<script>alert('Reserva cancelada con éxito');</script>";
                echo "<script>window.location.href = '/misReservas';</script>";
                exit();
            } catch (\Exception $e) {
                echo "<script>alert('Error al cancelar la reserva: " . $e->getMessage() . "');</script>";
                echo "<script>window.location.href = '/misReservas';</script>";
                exit();
            }
        }
    }

    // Edita una reserva existente
    public function editarReserva()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['user'])) {
                header("Location: /login");
                exit();
            }

            $idReserva = $_GET['id'];
            $reservaModel = new Reserva();

            if ($_POST) {
                $nuevaFechaInicio = $_POST['fecha_inicio'];
                $nuevaFechaFin = $_POST['fecha_fin'] ?? null;
                $nuevosAdultos = $_POST['adultos'];

                try {
                    $reservaModel->editarReserva($idReserva, $nuevaFechaInicio, $nuevaFechaFin, $nuevosAdultos);
                    echo "<script>alert('Reserva actualizada con éxito');</script>";
                    echo "<script>window.location.href = '/misReservas';</script>";
                    exit();
                } catch (\Exception $e) {
                    echo "<script>alert('Error al actualizar la reserva: " . $e->getMessage() . "');</script>";
                }
            }

            // Obtener los datos de la reserva para mostrarlos en el formulario
            $reserva = $reservaModel->obtenerReservasPorUsuario($idReserva);
            include __DIR__ . '/../Views/editarReserva.php';
        }
    }
}
