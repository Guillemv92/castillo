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
} elseif ($url == '/habitaciones') {
    $habitacionesController->mostrarFormulario();
} elseif ($url == '/disponibilidad') {
    $disponibilidadController->verificarDisponibilidad();
} elseif ($url == '/camping') {
    $campingController->mostrarFormulario();
} elseif ($url == '/procesarCampingReserva') {
    $campingController->procesarReserva();
}elseif ($url == '/login') {
    $authController->mostrarLogin();
}elseif ($url == '/procesarLogin') {
    $authController->procesarLogin();
} elseif ($url == '/logout') {
    $authController->logout();
}elseif ($url == '/registro') {
    $authController->mostrarRegistro();
}elseif ($url == '/procesarRegistro') {
    $authController->procesarRegistro();
}
