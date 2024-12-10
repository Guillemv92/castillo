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

// Instancia del controlador DashboardController
$dashboardController = new DashboardController();

// Verifica si la solicitud pertenece al panel de administración
if (strpos($url, '/admin') === 0) {
    if ($url == '/admin' || $url == '/admin/') {
        // Página principal del panel de administración
        $dashboardController->index();
        exit();
    } elseif ($url === '/admin/habitaciones-api') {
        // Manejo de habitaciones
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $stmt = $db->query("SELECT id_habitacion, nombre, precio, capacidad, estado, descripcion, imagen FROM habitaciones ORDER BY id_habitacion ASC");
            $habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($habitaciones);
        } else {
            http_response_code(405); // Método no permitido
            echo "Método no permitido";
        }
        exit();
    } elseif ($url === '/admin/servicios-api') {
        // Manejo de servicios
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Obtener servicios
            $stmt = $db->query("SELECT id_servicio, nombre, precio, cantidad_limite, estado, descripcion, imagen FROM servicios ORDER BY id_servicio ASC");
            $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($servicios);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Agregar un servicio
            $data = json_decode(file_get_contents('php://input'), true);

            $nombre = $data['nombre'] ?? null;
            $precio = $data['precio'] ?? null;
            $cantidad_limite = $data['cantidad_limite'] ?? null;
            $estado = $data['estado'] ?? 'I';
            $descripcion = $data['descripcion'] ?? '';
            $imagen = $data['imagen'] ?? '';

            if ($nombre && $precio) {
                try {
                    $stmt = $db->prepare("INSERT INTO servicios (nombre, precio, cantidad_limite, estado, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$nombre, $precio, $cantidad_limite, $estado, $descripcion, $imagen]);

                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode([
                        'id_servicio' => $db->lastInsertId(),
                        'nombre' => $nombre,
                        'precio' => $precio,
                        'cantidad_limite' => $cantidad_limite,
                        'estado' => $estado,
                        'descripcion' => $descripcion,
                        'imagen' => $imagen
                    ]);
                } catch (PDOException $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                http_response_code(400); // Solicitud incorrecta
                echo json_encode(['error' => 'Datos inválidos']);
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            // Actualizar un servicio
            $data = json_decode(file_get_contents('php://input'), true);

            $id = $data['id_servicio'] ?? null;
            $nombre = $data['nombre'] ?? null;
            $precio = $data['precio'] ?? null;
            $cantidad_limite = $data['cantidad_limite'] ?? null;
            $estado = $data['estado'] ?? null;
            $descripcion = $data['descripcion'] ?? null;
            $imagen = $data['imagen'] ?? null;

            if ($id && $nombre && $precio) {
                try {
                    $stmt = $db->prepare("UPDATE servicios SET nombre = ?, precio = ?, cantidad_limite = ?, estado = ?, descripcion = ?, imagen = ? WHERE id_servicio = ?");
                    $stmt->execute([$nombre, $precio, $cantidad_limite, $estado, $descripcion, $imagen, $id]);

                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['message' => 'Servicio actualizado']);
                } catch (PDOException $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Datos inválidos']);
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Eliminar un servicio
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? null;

            if ($id) {
                try {
                    $stmt = $db->prepare("DELETE FROM servicios WHERE id_servicio = ?");
                    $stmt->execute([$id]);

                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['message' => 'Servicio eliminado']);
                } catch (PDOException $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID no proporcionado']);
            }
        } else {
            http_response_code(405); // Método no permitido
            echo "Método no permitido";
        }
        exit();
    } else {
        http_response_code(404);
        echo "Página de administración no encontrada";
        exit();
    }
} else {
    // Aquí puedes agregar más lógica para otras secciones fuera del panel de administración
    http_response_code(404);
    echo "Página no encontrada";
    exit();
}
?>
