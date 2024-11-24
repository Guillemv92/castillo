<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Dejar Reseña</title>
</head>
<body>
    <div class="reseña-container">
        <div class="reseña-form">
            <h1>Dejar Reseña</h1>
            <form action="/procesarResenha" method="POST">
                <input type="hidden" name="reserva_id" value="<?= htmlspecialchars($idReserva); ?>">
                <div class="form-group">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>
                <div class="form-group">
                    <label for="calificacion">Calificación:</label>
                    <div class="rating">
                        <input type="radio" id="estrella5" name="calificacion" value="5">
                        <label for="estrella5" title="5 estrellas">★</label>
                        <input type="radio" id="estrella4" name="calificacion" value="4">
                        <label for="estrella4" title="4 estrellas">★</label>
                        <input type="radio" id="estrella3" name="calificacion" value="3">
                        <label for="estrella3" title="3 estrellas">★</label>
                        <input type="radio" id="estrella2" name="calificacion" value="2">
                        <label for="estrella2" title="2 estrellas">★</label>
                        <input type="radio" id="estrella1" name="calificacion" value="1">
                        <label for="estrella1" title="1 estrella">★</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" required></textarea>
                </div>
                <button type="submit">Enviar Reseña</button>
            </form>
        </div>
    </div>
</body>
</html>
