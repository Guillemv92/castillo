<?php

namespace App\Controllers;

use App\Models\Habitacion;

class DisponibilidadController {
    public function verificarDisponibilidad() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $fechaEntrada = $_GET['fecha_entrada'];
            $fechaSalida = $_GET['fecha_salida'];
            $adultos = $_GET['adult'];

            $habitacionModel = new Habitacion();
            $habitacionesDisponibles = $habitacionModel->obtenerHabitacionesDisponibles($fechaEntrada, $fechaSalida, $adultos);

            include_once __DIR__ . '/../Views/disponibilidad.php';
        }
    }

    public function verificarDisponibilidadAjax() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $fechaEntrada = $_GET['fecha_entrada'];
            $fechaSalida = $_GET['fecha_salida'];
            $adultos = $_GET['adult'];

            $habitacionModel = new Habitacion();
            $habitacionesDisponibles = $habitacionModel->obtenerHabitacionesDisponibles($fechaEntrada, $fechaSalida, $adultos);

            foreach ($habitacionesDisponibles as $habitacion) {
                echo "
                <div class='col-lg-6 col-md-6'>
                    <div class='single-news'>
                        <div class='news-img'>
                            <img src='/assets/img/{$habitacion['nombre']}-disponibilidad.jpg' alt='Image'>
                            <div class='dates'>
                                <span>Gs. {$habitacion['precio']}</span>
                            </div>
                        </div>
                        <div class='news-content-wrap'>
                            <h3>{$habitacion['nombre']}</h3>
                            <p>🚿 Baño ❄️ Aire acondicionado 🧼 Jabón 🧺 Toallas</p>
                            <p><strong>Precio: Gs. {$habitacion['precio']}</strong></p>

                            <div class='d-flex justify-content-between'>
                                <!-- Botón de Reservar -->
                                <a href='#' class='default-btn' onclick='redireccionarConDatos(event, \"{$habitacion['id_habitacion']}\")'>
                                    Reservar
                                    <i class='flaticon-right'></i>
                                </a>

                                <!-- Botón de Añadir al Carrito -->
                                <form action='/carrito/agregar' method='POST' style='display: inline;'>
                                    <input type='hidden' name='id_habitacion' value='{$habitacion['id_habitacion']}'>
                                    <input type='hidden' name='fecha_entrada' value='{$fechaEntrada}'>
                                    <input type='hidden' name='fecha_salida' value='{$fechaSalida}'>
                                    <input type='hidden' name='adultos' value='{$adultos}'>
                                    <button type='submit' class='default-btn' style='background-color: #28a745;'>
                                        Añadir al Carrito
                                        <i class='flaticon-cart'></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";
            }
        }
    }
}
