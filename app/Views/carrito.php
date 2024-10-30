<?php
// Asegúrate de que la sesión está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . "/../../templates/navbar.php";
?>

<br><br><br><br><br><br>

<h2>Carrito de Reservas</h2>

<?php if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border: 1px solid #ccc; padding: 8px;">Servicio</th>
                <th style="border: 1px solid #ccc; padding: 8px;">Fecha de Entrada</th>
                <th style="border: 1px solid #ccc; padding: 8px;">Adultos</th>
                <th style="border: 1px solid #ccc; padding: 8px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['carrito'] as $index => $item): ?>
                <tr>
                    <td style="border: 1px solid #ccc; padding: 8px;"><?= htmlspecialchars($item['tipo']); ?></td>
                    <td style="border: 1px solid #ccc; padding: 8px;"><?= htmlspecialchars($item['fecha_entrada']); ?></td>
                    <td style="border: 1px solid #ccc; padding: 8px;"><?= htmlspecialchars($item['adultos']); ?></td>
                    <td style="border: 1px solid #ccc; padding: 8px;">
                        <a href="/carrito/remover?index=<?= $index; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta reserva?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Botón para confirmar las reservas -->
    <a href="/carrito/confirmar" class="btn btn-primary" style="margin-top: 20px; display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">
        Confirmar Reservas
    </a>

<?php else: ?>
    <p>Tu carrito está vacío.</p>
<?php endif; ?>

<br><br><br><br><br>
<?php include __DIR__ . "/../../templates/footer.php"; ?>
