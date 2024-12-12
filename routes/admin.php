<?php
use App\Controllers\Admin\DashboardController;

// Obtener la URL solicitada
$url = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : null;

if ($url === null) {
    sendJsonResponse(404, "Página no encontrada");
    exit();
}

// Controlador del Dashboard (Asegúrate de tener esta clase y su método index)
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

/**
 * Manejo de la API de habitaciones
 * GET:    Lista todas las habitaciones
 * POST:   Inserta una nueva habitación
 * PUT:    Actualiza una habitación existente
 * DELETE: Elimina una habitación existente
 */
function handleHabitacionesApi($db) {
    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents('php://input'), true);

    switch ($method) {
        case 'GET':
            $stmt = $db->query("SELECT id_habitacion, nombre, precio, capacidad, estado, descripcion, imagen FROM habitaciones ORDER BY id_habitacion ASC");
            $habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            sendJsonResponse(200, $habitaciones);
            break;

        case 'POST':
            $nombre = $data['nombre'] ?? null;
            $capacidad = $data['capacidad'] ?? null;
            $estado = $data['estado'] ?? 'Disponible';
            $precio = $data['precio'] ?? null;
            $descripcion = $data['descripcion'] ?? '';
            $imagen = $data['imagen'] ?? '';

            if ($nombre && $capacidad && $precio) {
                try {
                    $stmt = $db->prepare("INSERT INTO habitaciones (nombre, capacidad, estado, precio, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$nombre, $capacidad, $estado, $precio, $descripcion, $imagen]);
                    $id = $db->lastInsertId();

                    sendJsonResponse(201, [
                        'id_habitacion' => $id,
                        'nombre' => $nombre,
                        'capacidad' => $capacidad,
                        'estado' => $estado,
                        'precio' => $precio,
                        'descripcion' => $descripcion,
                        'imagen' => $imagen
                    ]);
                } catch (PDOException $e) {
                    http_response_code(500);
                    sendJsonResponse(500, ['error' => $e->getMessage()]);
                }
            } else {
                http_response_code(400);
                sendJsonResponse(400, ['error' => 'Datos inválidos']);
            }
            break;

        case 'PUT':
            $id = $data['id_habitacion'] ?? null;
            $nombre = $data['nombre'] ?? null;
            $capacidad = $data['capacidad'] ?? null;
            $estado = $data['estado'] ?? null;
            $precio = $data['precio'] ?? null;
            $descripcion = $data['descripcion'] ?? null;
            $imagen = $data['imagen'] ?? null;

            if ($id && $nombre && $capacidad && $precio) {
                try {
                    $stmt = $db->prepare("UPDATE habitaciones SET nombre = ?, capacidad = ?, estado = ?, precio = ?, descripcion = ?, imagen = ? WHERE id_habitacion = ?");
                    $stmt->execute([$nombre, $capacidad, $estado, $precio, $descripcion, $imagen, $id]);

                    sendJsonResponse(200, ['message' => 'Habitación actualizada correctamente']);
                } catch (PDOException $e) {
                    http_response_code(500);
                    sendJsonResponse(500, ['error' => $e->getMessage()]);
                }
            } else {
                http_response_code(400);
                sendJsonResponse(400, ['error' => 'Datos inválidos o incompletos']);
            }
            break;

        case 'DELETE':
            $id = $data['id'] ?? null;
            if ($id) {
                try {
                    $stmt = $db->prepare("DELETE FROM habitaciones WHERE id_habitacion = ?");
                    $stmt->execute([$id]);

                    sendJsonResponse(200, ['message' => 'Habitación eliminada correctamente']);
                } catch (PDOException $e) {
                    http_response_code(500);
                    sendJsonResponse(500, ['error' => $e->getMessage()]);
                }
            } else {
                http_response_code(400);
                sendJsonResponse(400, ['error' => 'ID no proporcionado']);
            }
            break;

        default:
            http_response_code(405);
            sendJsonResponse(405, "Método no permitido");
    }
}

/**
 * Manejo de la API de servicios
 */
function handleServiciosApi($db) {
    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents('php://input'), true);

    switch ($method) {
        case 'GET':
            $stmt = $db->query("SELECT id_servicio, nombre, precio, cantidad_limite, estado, descripcion, imagen FROM servicios ORDER BY id_servicio ASC");
            $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            sendJsonResponse(200, $servicios);
            break;

        case 'POST':
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
                    http_response_code(500);
                    sendJsonResponse(500, ['error' => $e->getMessage()]);
                }
            } else {
                http_response_code(400);
                sendJsonResponse(400, "Datos inválidos");
            }
            break;

        case 'PUT':
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
                    http_response_code(500);
                    sendJsonResponse(500, ['error' => $e->getMessage()]);
                }
            } else {
                http_response_code(400);
                sendJsonResponse(400, "Datos inválidos");
            }
            break;

        case 'DELETE':
            if (isset($data['id'])) {
                try {
                    $stmt = $db->prepare("DELETE FROM servicios WHERE id_servicio = ?");
                    $stmt->execute([$data['id']]);
                    sendJsonResponse(200, "Servicio eliminado");
                } catch (PDOException $e) {
                    http_response_code(500);
                    sendJsonResponse(500, ['error' => $e->getMessage()]);
                }
            } else {
                http_response_code(400);
                sendJsonResponse(400, "ID no proporcionado");
            }
            break;

        default:
            http_response_code(405);
            sendJsonResponse(405, "Método no permitido");
    }
}

function sendJsonResponse($status, $data) {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    if (is_array($data) || is_object($data)) {
        echo json_encode($data);
    } else {
        echo json_encode(["message" => $data]);
    }
}
