<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Panel de Administración">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="/admin/servicios-api" class="admin-link">Servicios</a></li>
                <li><a href="/admin/habitaciones-api" class="admin-link">Habitaciones</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <p>Selecciona una opción del menú para cargar datos.</p>
    </main>
    <footer>
        <p>© <?php echo date('Y'); ?> El Castillo - Panel de Administración</p>
    </footer>

    <script src="/assets/js/admin.js"></script>
</body>
</html>
