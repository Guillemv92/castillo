<?php
use App\Controllers\Admin\DashboardController;

// Inicializa $url de manera segura
$url = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : null;

// Si $url es null, devuelve un error 404
if ($url === null) {
    http_response_code(404);
    echo "Página no encontrada";
    exit();
}

$dashboardController = new DashboardController();

if (strpos($url, '/admin') === 0) {
    if ($url == '/admin' || $url == '/admin/') {
        $dashboardController->index();
        exit();
    } elseif ($url === '/admin/habitaciones-api') {
        $stmt = $db->query("SELECT id_habitacion, nombre, precio, capacidad, estado, descripcion, imagen FROM habitaciones ORDER BY id_habitacion ASC");
        $habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($habitaciones);
        exit();
    } elseif ($url === '/admin/servicios-api') {
        $stmt = $db->query("SELECT id_servicio, nombre, precio, cantidad_limite, estado, descripcion, imagen FROM servicios ORDER BY id_servicio ASC");
        $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($servicios);
        exit();
    } else {
        http_response_code(404);
        echo "Página de administración no encontrada";
        exit();
    }
} else {
    http_response_code(404);
    echo "Página no encontrada";
    exit();
}




?>