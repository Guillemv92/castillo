<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dejar Reseña</title>
</head>
<body>
    <h1>Dejar Reseña</h1>
    <form action="/procesarResenha" method="POST">
        <input type="hidden" name="reserva_id" value="<?= htmlspecialchars($idReserva); ?>">
        <div>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
        </div>
        <div>
            <label for="calificacion">Calificación (1 a 5):</label>
            <input type="number" id="calificacion" name="calificacion" min="1" max="5" required>
        </div>
        <div>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>
        </div>
        <button type="submit">Enviar Reseña</button>
    </form>
</body>
</html>
