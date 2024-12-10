<?php
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insertar un nuevo servicio
    $data = json_decode(file_get_contents('php://input'), true);

    $nombre = $data['nombre'] ?? null;
    $precio = $data['precio'] ?? null;
    $cantidad_limite = $data['cantidad_limite'] ?? null;
    $estado = $data['estado'] ?? 'I';
    $descripcion = $data['descripcion'] ?? '';
    $imagen = $data['imagen'] ?? '';

    if ($nombre && $precio) {
        try {
            $stmt = $pdo->prepare("INSERT INTO servicios (nombre, precio, cantidad_limite, estado, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $precio, $cantidad_limite, $estado, $descripcion, $imagen]);

            echo json_encode([
                'id_servicio' => $pdo->lastInsertId(),
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
        http_response_code(400);
        echo json_encode(['error' => 'Datos inválidos']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Actualizar un servicio existente
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
            $stmt = $pdo->prepare("UPDATE servicios SET nombre = ?, precio = ?, cantidad_limite = ?, estado = ?, descripcion = ?, imagen = ? WHERE id_servicio = ?");
            $stmt->execute([$nombre, $precio, $cantidad_limite, $estado, $descripcion, $imagen, $id]);

            echo json_encode(['message' => 'Servicio actualizado correctamente']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Datos inválidos o incompletos']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Eliminar un servicio existente
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;

    if ($id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM servicios WHERE id_servicio = ?");
            $stmt->execute([$id]);

            echo json_encode(['message' => 'Servicio eliminado correctamente']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'ID no proporcionado']);
    }
} else {
    // Método no permitido
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
?>
