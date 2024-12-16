<?php
include __DIR__ . "/../../templates/navbar.php";
?>

<!-- Start Mis Reservas Area -->
<section class="cart-area ptb-100">
    <div class="container">
        <h2>Mis Reservas</h2>

        <?php if (!empty($reservas)): ?>
            <div class="cart-wraps">
                <div class="cart-table table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Servicio</th>
                                <th scope="col">Fecha de Entrada</th>
                                <th scope="col">Fecha de Salida</th>
                                <th scope="col">Adultos</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservas as $reserva): ?>
                                <tr>
                                    <td class="product-name">
                                        <?= htmlspecialchars($reserva['nombre_servicio']); ?>
                                    </td>
                                    <td class="product-date">
                                        <?= htmlspecialchars($reserva['fecha_inicio'] ?? '-'); ?>
                                    </td>
                                    <td class="product-date">
                                        <?= htmlspecialchars($reserva['fecha_fin'] ?? '-'); ?>
                                    </td>
                                    <td class="product-quantity">
                                        <?= htmlspecialchars($reserva['adultos']); ?>
                                    </td>
                                    <td class="product-actions">
                                        <a href="/misReservas/editar?id=<?= $reserva['id_reserva']; ?>" class="edit">
                                            <i class="bx bx-edit"></i> Editar
                                        </a>
                                        <a href="/misReservas/cancelar?id=<?= $reserva['id_reserva']; ?>" class="remove" onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?');">
                                            <i class="bx bx-trash"></i> Cancelar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <p>No tienes reservas activas.</p>
        <?php endif; ?>
    </div>
</section>
<!-- End Mis Reservas Area -->

<?php include __DIR__ . "/../../templates/footer.php"; ?>
