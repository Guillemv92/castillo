<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
}

// Similar para PUT y DELETE como en el ejemplo original.
