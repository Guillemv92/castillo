<?php

use App\Controllers\Admin\DashboardController;

// Obtener la URL solicitada
$url = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : null;

// Si la URL no es válida, devolver error 404
if ($url === null) {
    sendJsonResponse(404, "Página no encontrada");
    exit();
}

// Controlador del Dashboard
$dashboardController = new DashboardController();

// Enrutador para las rutas del panel de administración
if (strpos($url, '/admin') === 0) {
    if ($url === '/admin' || $url === '/admin/') {
        // Cargar la vista principal del panel de administración
        $dashboardController->index();
        exit();
    } elseif ($url === '/admin/habitaciones-api') {
        handleHabitacionesApi($db);
        exit();
    } elseif ($url === '/admin/servicios-api') {
        handleServiciosApi($db);
        exit();
    } else {
        sendJsonResponse(404, "Página de administración no encontrada");
    }
} else {
    sendJsonResponse(404, "Página no encontrada");
}

// Manejo de la API de habitaciones
function handleHabitacionesApi($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $db->query("SELECT id_habitacion, nombre, precio, capacidad, estado, descripcion, imagen FROM habitaciones ORDER BY id_habitacion ASC");
        $habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        sendJsonResponse(200, $habitaciones);
    } else {
        sendJsonResponse(405, "Método no permitido");
    }
}

// Manejo de la API de servicios
function handleServiciosApi($db) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $stmt = $db->query("SELECT id_servicio, nombre, precio, cantidad_limite, estado, descripcion, imagen FROM servicios ORDER BY id_servicio ASC");
            $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            sendJsonResponse(200, $servicios);
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['nombre'], $data['precio'])) {
                try {
                    $stmt = $db->prepare("INSERT INTO servicios (nombre, precio, cantidad_limite, estado, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $data['nombre'],
                        $data['precio'],
                        $data['cantidad_limite'] ?? null,
                        $data['estado'] ?? 'I',
                        $data['descripcion'] ?? '',
                        $data['imagen'] ?? ''
                    ]);
                    sendJsonResponse(201, [
                        'id_servicio' => $db->lastInsertId(),
                        ...$data
                    ]);
                } catch (PDOException $e) {
                    sendJsonResponse(500, ['error' => $e->getMessage()]);
                }
            } else {
                sendJsonResponse(400, "Datos inválidos");
            }
            break;

        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['id_servicio'], $data['nombre'], $data['precio'])) {
                try {
                    $stmt = $db->prepare("UPDATE servicios SET nombre = ?, precio = ?, cantidad_limite = ?, estado = ?, descripcion = ?, imagen = ? WHERE id_servicio = ?");
                    $stmt->execute([
                        $data['nombre'],
                        $data['precio'],
                        $data['cantidad_limite'] ?? null,
                        $data['estado'] ?? null,
                        $data['descripcion'] ?? null,
                        $data['imagen'] ?? null,
                        $data['id_servicio']
                    ]);
                    sendJsonResponse(200, "Servicio actualizado");
                } catch (PDOException $e) {
                    sendJsonResponse(500, ['error' => $e->getMessage()]);
                }
            } else {
                sendJsonResponse(400, "Datos inválidos");
            }
            break;

        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['id'])) {
                try {
                    $stmt = $db->prepare("DELETE FROM servicios WHERE id_servicio = ?");
                    $stmt->execute([$data['id']]);
                    sendJsonResponse(200, "Servicio eliminado");
                } catch (PDOException $e) {
                    sendJsonResponse(500, ['error' => $e->getMessage()]);
                }
            } else {
                sendJsonResponse(400, "ID no proporcionado");
            }
            break;

        default:
            sendJsonResponse(405, "Método no permitido");
    }
}

// Función auxiliar para enviar respuestas JSON
function sendJsonResponse($status, $data) {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
}
?>
