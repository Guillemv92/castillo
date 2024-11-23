<?php

namespace App\Controllers;

use App\Models\Resenha;
use App\Models\Reserva;

class ResenhaController
{
    public function mostrarFormulario()
{
    if (!isset($_GET['reserva_id'])) {
        http_response_code(400);
        echo "ID de reserva no proporcionado.";
        return;
    }

    // Obtener el ID de la reserva
    $idReserva = $_GET['reserva_id'];

    // Obtener datos de la reserva
    $reservaModel = new Reserva();
    $reserva = $reservaModel->obtenerReservaPorId($idReserva);

    // Verifica si la reserva existe
    if (!$reserva) {
        http_response_code(404);
        echo "Reserva no encontrada.";
        return;
    }

    // Validación adicional de fecha (si lo deseas)
    /*
    $fechaSalida = new \DateTime($reserva['fecha_fin']);
    $fechaActual = new \DateTime();
    if ($fechaActual < $fechaSalida) {
        http_response_code(403);
        echo "La reseña solo puede completarse después de la fecha de salida.";
        return;
    }
    */

    // Incluir la vista si todo está correcto
    include __DIR__ . '/../Views/resenhaFormulario.php';
}

public function procesarResenha()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $resenhaModel = new Resenha();
        $reservaId = $_POST['reserva_id'];
        $titulo = $_POST['titulo'];
        $calificacion = $_POST['calificacion'];
        $descripcion = $_POST['descripcion'];

        try {
            $resenhaModel->guardarResenha($reservaId, $titulo, $calificacion, $descripcion);
            // Redirige al inicio después de guardar
            header("Location: /");
            exit();
        } catch (\Exception $e) {
            error_log("Error al guardar reseña: " . $e->getMessage());
            // Muestra un error al usuario
            echo "<script>alert('Hubo un problema al guardar tu reseña. Por favor, intenta nuevamente.');</script>";
            echo "<script>window.history.back();</script>";
            exit();
        }
    } else {
        http_response_code(405); // Método no permitido
        echo "Método no permitido.";
    }
}
}
