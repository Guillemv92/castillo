<?php

use App\Controllers\PasareldiaController;

$pasareldiaController = new PasareldiaController();

if ($_SERVER['REQUEST_URI'] == '/pasareldia') {
    $pasareldiaController->mostrarFormulario();
} elseif ($_SERVER['REQUEST_URI'] == '/procesarReserva') {
    $pasareldiaController->procesarReserva();
}


?>