<?php
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
                    <h3><?= $servicio === 'habitacion' ? htmlspecialchars($nombre) : ucfirst(str_replace('_', ' ', $servicio)); ?></h3>
                    <p><strong></strong> <?= htmlspecialchars($descripcion) ?></p>
                    <img class="imagen-servicio" src="<?= htmlspecialchars($imagen) ?>" alt="<?= htmlspecialchars($nombre) ?>">


                </div>
            </div>

            <div class="col-lg-4">
                <div class="service-sidebar-area">
                    <div class="service-list service-card">
                        <h3 class="service-details-title">Detalles de la Reserva</h3>
                        <ul>
                            <li>
                                <strong>Servicio:</strong> <?= $servicio === 'habitacion' ? htmlspecialchars($nombre) : ucfirst(str_replace('_', ' ', $servicio)); ?>
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
                        paypal.Buttons({
                            createOrder: function(data, actions) {
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: <?= json_encode($precioEnDolares); ?>,
                                            currency_code: 'USD'
                                        }
                                    }]
                                });
                            },
                            onApprove: function(data, actions) {
                                return actions.order.capture().then(function(details) {
                                    // Redirigir con el paymentId
                                    window.location.href = `/procesarReserva?paymentId=${data.orderID}`;
                                });
                            }
                        }).render('#paypal-button-container');
                    </script>

                    <!-- Sección FAQ -->
                    <div class="service-faq service-card">
                        <h3 class="service-details-title">FAQ</h3>
                        <div class="faq-area">
                            <div class="questions-bg-area">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="faq-accordion">
                                            <ul class="accordion">
                                                <li class="accordion-item">
                                                    <a class="accordion-title " href="javascript:void(0)">
                                                        <i class='bx bx-chevron-down'></i>
                                                        ¿La recepción está abierta las 24 horas?
                                                    </a>
                                                    <p class="accordion-content">Nuestra recepción está abierta todo el día para su comodidad.</p>
                                                </li>
                                                <li class="accordion-item">
                                                    <a class="accordion-title" href="javascript:void(0)">
                                                        <i class='bx bx-chevron-down'></i>
                                                        ¿Puedo dejar mi equipaje?
                                                    </a>
                                                    <p class="accordion-content">Sí, disponemos de servicio de guarda equipajes para nuestros huéspedes.</p>
                                                </li>
                                                <li class="accordion-item">
                                                    <a class="accordion-title" href="javascript:void(0)">
                                                        <i class='bx bx-chevron-down'></i>
                                                        ¿Cuál es el aeropuerto más cercano?
                                                    </a>
                                                    <p class="accordion-content">El aeropuerto más cercano está a 20 minutos en coche.</p>
                                                </li>
                                                <li class="accordion-item">
                                                    <a class="accordion-title" href="javascript:void(0)">
                                                        <i class='bx bx-chevron-down'></i>
                                                        ¿Puedo alquilar un coche en el hotel o cerca?
                                                    </a>
                                                    <p class="accordion-content">Sí, hay opciones de alquiler de coches en el hotel y en las inmediaciones.</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Service Details Area -->


<!-- start Testimonials Area -->
<section class="testimonials-area pb-100">
    <div class="container">
        <div class="section-title">
            <span>Testimonios</span>
            <h2>¿Qué dicen nuestros clientes?</h2>
        </div>
        <div class="testimonials-wrap owl-carousel owl-theme">
            <?php if (!empty($resenhas)): ?>
                <?php foreach ($resenhas as $resenha): ?>
                    <div class="single-testimonials">
                        <ul>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <li>
                                    <i class="bx <?= $i <= $resenha['calificacion'] ? 'bxs-star' : 'bx-star'; ?>"></i>
                                </li>
                            <?php endfor; ?>
                        </ul>
                        <h3><?= htmlspecialchars($resenha['titulo']); ?></h3>
                        <p>“<?= htmlspecialchars($resenha['descripcion']); ?>”</p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay reseñas disponibles para este servicio.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- End Testimonials Area -->

<?php include __DIR__ . "/../../templates/footer.php"; ?>
