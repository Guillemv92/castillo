<?php

use App\Controllers\AuthController;
use App\Controllers\PasareldiaController;
use App\Controllers\HabitacionesController;
use App\Controllers\DisponibilidadController;
use App\Controllers\CampingController;
use App\Controllers\ConfirmacionController; // Importar el nuevo controlador

// Instanciar los controladores
$authController = new AuthController();
$pasareldiaController = new PasareldiaController();
$habitacionesController = new HabitacionesController();
$disponibilidadController = new DisponibilidadController();
$campingController = new CampingController();
$confirmacionController = new ConfirmacionController(); // Instanciar el controlador de confirmación

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
} elseif ($url == '/confirmacionReserva') {
    $confirmacionController->mostrarConfirmacion(); // Llamada al método para mostrar la confirmación
} elseif ($url == '/procesarPasarDiaReserva') {
    $pasareldiaController->procesarReserva(); // Procesar la reserva
}elseif ($url == '/procesarReserva') {
    // Asegúrate de capturar GET y POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['paymentId'])) {
        $confirmacionController->procesarReserva();
    } else {
        http_response_code(405); // Método no permitido
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
} else {
    http_response_code(404);
    echo "Página no encontrada";
}
