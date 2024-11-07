<?php
session_start();
include __DIR__ . "/../../templates/navbar.php";
// Los datos ya están disponibles gracias al controlador
?>
<script src="https://www.paypal.com/sdk/js?client-id=AWWwTnNeFDYSmO5RSMRrIaLngQtP5cFnOaw7try4Un6Rvv9AYSS5PlEpN22pRKZDZ_zyL37humBZ7bhw&currency=USD"></script>

<!-- Start Service Details Area -->
<section class="service-details-area room-details-right-sidebar ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="service-details-wrap service-right">
                    <h3><?= $servicio === 'habitacion' ? htmlspecialchars($nombreHabitacion) : ucfirst(str_replace('_', ' ', $servicio)); ?></h3>
                    <p>Detalle del servicio seleccionado: <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $servicio))); ?>. Revisa la información antes de confirmar tu reserva.</p>
                    <div class="service-img-wrap owl-carousel owl-theme mb-30">
                        <div class="single-services-imgs">
                            <img src="../assets/img/services-details/2.jpg" alt="Imagen del servicio">
                        </div>
                        <div class="single-services-imgs">
                            <img src="../assets/img/services-details/2.jpg" alt="Image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="service-sidebar-area">
                    <div class="service-list service-card">
                        <h3 class="service-details-title">Detalles de la Reserva</h3>
                        <ul>
                            <li>
                                <strong>Servicio:</strong> <?= $servicio === 'habitacion' ? htmlspecialchars($nombreHabitacion) : ucfirst(str_replace('_', ' ', $servicio)); ?>
                                <i class='bx bx-check'></i>
                            </li>
                            <li>
                                <strong>Fecha de Entrada:</strong> <?= htmlspecialchars($fechaEntrada); ?>
                                <i class='bx bx-check'></i>
                            </li>
                            <?php if ($servicio !== 'pasar_el_dia'): ?>
                                <li>
                                    <strong>Fecha de Salida:</strong> <?= htmlspecialchars($fechaSalida); ?>
                                    <i class='bx bx-check'></i>
                                </li>
                            <?php endif; ?>
                            <li>
                                <strong>Adultos:</strong> <?= htmlspecialchars($adultos); ?>
                                <i class='bx bx-check'></i>
                            </li>
                            <li>
                                <strong>Precio Unitario:</strong> Gs. <?= number_format($precioUnitario, 0, ',', '.'); ?>
                                <i class='bx bx-check'></i>
                            </li>
                            <li>
                                <strong>Precio Total:</strong> Gs. <?= number_format($costoTotal, 0, ',', '.'); ?>
                                <i class='bx bx-check'></i>
                            </li>
                        </ul>
                    </div>

                    <!-- Botón de pago de PayPal -->
                    <div id="paypal-button-container"></div>

                    <!-- Script para manejar el botón de PayPal -->
                    <script>
                        const guaraniAmount = <?= json_encode($costoTotal); ?>; // Precio total en guaraníes como entero
                        // Conversión de guaraníes a dólares
                        const conversionRate = 1 / 7300; // Ajusta según la tasa actual
                        paypal.Buttons({
                            createOrder: function(data, actions) {
                                const usdAmount = (guaraniAmount * conversionRate).toFixed(2);
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: usdAmount,
                                            currency_code: 'USD'
                                        }
                                    }]
                                });
                            },
                            onApprove: function(data, actions) {
                                return actions.order.capture().then(function(details) {
                                    alert('Pago completado con éxito');
                                    // Redirigir a procesar la reserva con el ID de pago y datos de la reserva
                                    window.location.href = `/procesarReserva?paymentId=${data.orderID}&servicio=${encodeURIComponent(<?= json_encode($servicio) ?>)}&id_habitacion=${encodeURIComponent(<?= json_encode($habitacionId ?? '') ?>)}&fecha_entrada=${encodeURIComponent(<?= json_encode($fechaEntrada) ?>)}&fecha_salida=${encodeURIComponent(<?= json_encode($fechaSalida) ?>)}&adultos=${encodeURIComponent(<?= json_encode($adultos) ?>)}&precio_total=${encodeURIComponent(<?= json_encode($costoTotal) ?>)}`;
                                });
                            }
                        }).render('#paypal-button-container');
                    </script>
                    <!-- Información de Contacto -->
                    <div class="service-list service-card">
                        <h3 class="service-details-title">Contact Info</h3>
                        <ul>
                            <li>
                                <a href="tel:+8006036035">
                                    +800 603 6035
                                    <i class='bx bx-phone-call bx-rotate-270'></i>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:hello@ecorik.com">
                                    hello@ecorik.com
                                    <i class='bx bx-envelope'></i>
                                </a>
                            </li>
                            <li>
                                123, Western Road, Australia
                                <i class='bx bx-location-plus'></i>
                            </li>
                            <li>
                                9:00 AM – 8:00 PM
                                <i class="bx bx-time"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Service Details Area -->

<?php include __DIR__ . "/../../templates/footer.php"; ?>