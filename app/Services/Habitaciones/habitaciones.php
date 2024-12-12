<?php
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insertar una nueva habitación
    $data = json_decode(file_get_contents('php://input'), true);

    $nombre = $data['nombre'] ?? null;
    $capacidad = $data['capacidad'] ?? null;
    $estado = $data['estado'] ?? 'Disponible';
    $precio = $data['precio'] ?? null;
    $descripcion = $data['descripcion'] ?? '';
    $imagen = $data['imagen'] ?? '';

    if ($nombre && $capacidad && $precio) {
        try {
            $stmt = $pdo->prepare("INSERT INTO habitaciones (nombre, capacidad, estado, precio, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $capacidad, $estado, $precio, $descripcion, $imagen]);
            $id = $pdo->lastInsertId();

            echo json_encode([
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
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Datos inválidos']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Actualizar una habitación existente
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id_habitacion'] ?? null;
    $nombre = $data['nombre'] ?? null;
    $capacidad = $data['capacidad'] ?? null;
    $estado = $data['estado'] ?? null;
    $precio = $data['precio'] ?? null;
    $descripcion = $data['descripcion'] ?? null;
    $imagen = $data['imagen'] ?? null;

    if ($id && $nombre && $capacidad && $precio) {
        try {
            $stmt = $pdo->prepare("UPDATE habitaciones SET nombre = ?, capacidad = ?, estado = ?, precio = ?, descripcion = ?, imagen = ? WHERE id_habitacion = ?");
            $stmt->execute([$nombre, $capacidad, $estado, $precio, $descripcion, $imagen, $id]);

            echo json_encode(['message' => 'Habitación actualizada correctamente']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Datos inválidos o incompletos']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Eliminar una habitación existente
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;

    if ($id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM habitaciones WHERE id_habitacion = ?");
            $stmt->execute([$id]);

            echo json_encode(['message' => 'Habitación eliminada correctamente']);
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
