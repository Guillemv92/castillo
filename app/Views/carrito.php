<?php
// Asegúrate de que la sesión está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . "/../../templates/navbar.php";
?>

<!-- Start Cart Area -->
<section class="cart-area ptb-100">
    <div class="container">
        <h2>Carrito de Reservas</h2>

        <?php if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
            <div class="cart-wraps">
                <div class="cart-table table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Servicio</th>
                                <th scope="col">Fecha de Entrada</th>
                                <th scope="col">Adultos</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['carrito'] as $index => $item): ?>
                                <tr>
                                    <td class="product-name">
                                        <?= htmlspecialchars($item['tipo']); ?>
                                    </td>
                                    <td class="product-date">
                                        <?= htmlspecialchars($item['fecha_entrada']); ?>
                                    </td>
                                    <td class="product-quantity">
                                        <?= htmlspecialchars($item['adultos']); ?>
                                    </td>
                                    <td class="product-actions">
                                        <a href="/carrito/remover?index=<?= $index; ?>" class="remove" onclick="return confirm('¿Estás seguro de que deseas eliminar esta reserva?');">
                                            <i class="bx bx-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Cart Buttons -->
                <div class="cart-buttons">
                    <div class="row align-items-center">
                        <div class="col-lg-7 col-sm-7 col-md-7">
                            <div class="continue-shopping-box">
                                <a href="/" class="default-btn">
                                    Seguir Reservando
                                    <i class="flaticon-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-5 col-sm-5 col-md-5 text-right">
                            <a href="/carrito/confirmar" class="default-btn">
                                Confirmar Reservas
                                <i class="flaticon-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p>Tu carrito está vacío.</p>
        <?php endif; ?>
    </div>
</section>
<!-- End Cart Area -->

<?php include __DIR__ . "/../../templates/footer.php"; ?>
