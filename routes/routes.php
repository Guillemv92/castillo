<?php

use App\Controllers\AuthController;
use App\Controllers\PasareldiaController;
use App\Controllers\HabitacionesController;
use App\Controllers\DisponibilidadController;
use App\Controllers\CampingController;

$authController = new AuthController();
$pasareldiaController = new PasareldiaController();
$habitacionesController = new HabitacionesController();
$disponibilidadController = new DisponibilidadController();
$campingController = new CampingController();

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($url == '/' || $url == '/index.php') {
    include __DIR__ . "/../templates/navbar.php";
    include __DIR__ . "/../app/Views/index.php";
    include __DIR__ . "/../templates/footer.php";
    exit();
} elseif ($url == '/pasareldia') {
    $pasareldiaController->mostrarFormulario();
} elseif ($url == '/procesarReserva') {
    $pasareldiaController->procesarReserva();
} elseif ($url == '/pasareldia/agregarAlCarrito') {
    $pasareldiaController->agregarAlCarrito();
} elseif ($url == '/habitaciones') {
    $habitacionesController->mostrarFormulario();
} elseif ($url == '/disponibilidad') {
    $disponibilidadController->verificarDisponibilidad();
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
}

// Rutas para el carrito
elseif ($url == '/carrito') {
    include "../app/Views/carrito.php";
} elseif ($url == '/carrito/confirmar') {
    // Procesar la confirmación de las reservas en el carrito
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        // Aquí puedes agregar lógica adicional para guardar los datos en la base de datos

        // Vaciar el carrito tras confirmar
        $_SESSION['carrito'] = [];
        echo "<script>alert('Reserva confirmada. Gracias por su compra');</script>";
        echo "<script>window.location.href = '/';</script>";
        exit();
    } else {
        echo "<script>alert('El carrito está vacío');</script>";
        echo "<script>window.location.href = '/carrito';</script>";
        exit();
    }
} else {
    // Ruta no encontrada
    http_response_code(404);
    echo "Página no encontrada";
}
