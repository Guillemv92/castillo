<?php

namespace App\Controllers;

use App\Models\Reserva;
use App\Models\Servicio;

class PasareldiaController {
    public function mostrarFormulario() {

        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
        
        include_once __DIR__ . "/../Views/pasareldia.php";
    }

    public function procesarReserva() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fechaEntrada = $_POST['fecha_entrada'];
            $adultos = $_POST['adult'];
            $action = $_POST['action'];

             // ID del servicio para "pasar el día" (ajusta según tu base de datos)
            $idServicioPasarElDia = 1;

            // Instancia del modelo Servicio para verificar disponibilidad de "pasar el día"
            $servicioModel = new Servicio();
            $disponible = $servicioModel->obtenerDisponibilidadServicio($idServicioPasarElDia, $fechaEntrada, $fechaEntrada, $adultos); 

            if ($disponible) {
                if ($action === 'reservar') {
                    header("Location: /confirmacionReserva?servicio=pasar_el_dia&fecha_entrada=$fechaEntrada&adultos=$adultos");
                    exit();
                } elseif ($action === 'carrito') {
                    if (!isset($_SESSION['carrito'])) {
                        $_SESSION['carrito'] = [];
                    }
                    
                    $_SESSION['carrito'][] = [
                        'servicio' => 'pasar_el_dia',
                        'fecha_entrada' => $fechaEntrada,
                        'adultos' => $adultos
                    ];

                    echo "<script>alert('Reserva de Pasar el Día agregada al carrito. Ir al carrito para confirmar la compra.');</script>";
                    echo "<script>window.location.href = '/pasareldia';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Lo sentimos, no hay disponibilidad suficiente para pasar el día en la fecha seleccionada.');</script>";
                echo "<script>window.location.href = '/pasareldia';</script>";
                exit();
            }
        }
    }
}
