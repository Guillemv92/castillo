<?php

use App\Controllers\AuthController;
use App\Controllers\PasareldiaController;
use App\Controllers\HabitacionesController;
use App\Controllers\DisponibilidadController;
use App\Controllers\CampingController;
use App\Controllers\ConfirmacionController;
use App\Controllers\ReservasController; // Agregar el nuevo controlador de reservas

// Instanciar los controladores
$authController = new AuthController();
$pasareldiaController = new PasareldiaController();
$habitacionesController = new HabitacionesController();
$disponibilidadController = new DisponibilidadController();
$campingController = new CampingController();
$confirmacionController = new ConfirmacionController();
$reservasController = new ReservasController(); // Instanciar el nuevo controlador

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($url == '/' || $url == '/index.php') {
    include __DIR__ . "/../templates/navbar.php";
    include __DIR__ . "/../app/Views/index.php";
    include __DIR__ . "/../templates/footer.php";
    exit();
} elseif ($url == '/pasareldia') {
    $pasareldiaController->mostrarFormulario();
} elseif ($url == '/habitaciones') {
    $habitacionesController->mostrarFormulario();
} elseif ($url == '/verificarDisponibilidad') {
    $disponibilidadController->verificarDisponibilidadAjax(); // AJAX para actualizar habitaciones
} elseif ($url == '/disponibilidad') {
    $disponibilidadController->verificarDisponibilidad(); // Muestra la página completa de disponibilidad
} elseif ($url == '/camping') {
    $campingController->mostrarFormulario();
} elseif ($url == '/procesarCampingReserva') {
    $campingController->procesarReserva();
} elseif ($url == '/login') {
    $authController->mostrarLogin();
} elseif ($url == '/procesarLogin') {
    $authController->procesarLogin();
} elseif ($url == '/logout') {
    $authController->logout();
} elseif ($url == '/registro') {
    $authController->mostrarRegistro();
} elseif ($url == '/procesarRegistro') {
    $authController->procesarRegistro();
} elseif ($url == '/confirmacionReserva') {
    $confirmacionController->mostrarConfirmacion(); 
} elseif ($url == '/procesarPasarDiaReserva') {
    $pasareldiaController->procesarReserva();
} elseif ($url == '/procesarReserva') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['paymentId'])) {
        $confirmacionController->procesarReserva();
    } else {
        http_response_code(405);
        echo "Método no permitido";
    }
}

// Rutas para el carrito
elseif ($url == '/carrito') {
    include "../app/Views/carrito.php";
} elseif ($url == '/carrito/confirmar') {
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
        echo "<script>alert('Reserva confirmada. Gracias por su compra');</script>";
        echo "<script>window.location.href = '/';</script>";
        exit();
    } else {
        echo "<script>alert('El carrito está vacío');</script>";
        echo "<script>window.location.href = '/carrito';</script>";
        exit();
    }
}

// Rutas para "Mis Reservas"
elseif ($url == '/misReservas') {
    $reservasController->mostrarMisReservas(); // Mostrar todas las reservas activas del usuario
} elseif ($url == '/misReservas/cancelar') {
    $reservasController->cancelarReserva(); // Cancelar una reserva
} elseif ($url == '/misReservas/editar') {
    $reservasController->editarReserva(); // Editar una reserva
} else {
    http_response_code(404);
    echo "Página no encontrada";
}
