<?php
session_start(); // Iniciar la sesión si aún no está iniciada

include __DIR__ . "/../../templates/navbar.php";

// Obtener datos de la reserva desde los parámetros de la URL
$servicio = $_GET['servicio'] ?? '';
$fechaEntrada = $_GET['fecha_entrada'] ?? 'N/A';
$adultos = $_GET['adultos'] ?? 1;
$fechaSalida = $_GET['fecha_salida'] ?? 'N/A'; // Agregar si también se incluye una fecha de salida

// Lógica para establecer el costo basado en el servicio seleccionado (podrías adaptarla para llamar a la base de datos)
$costo = 0;
if ($servicio === 'pasar_el_dia') {
    $costo = 50000; // Ejemplo de costo para pasar el día
} elseif ($servicio === 'camping') {
    $costo = 80000; // Ejemplo de costo para camping
} elseif ($servicio === 'habitacion') {
    $costo = 120000; // Ejemplo de costo para una habitación
}
?>

<!-- Start Service Details Area -->
<section class="service-details-area room-details-right-sidebar ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="service-details-wrap service-right">
                    <h3><?= ucfirst(str_replace('_', ' ', $servicio)); ?></h3>
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
                                <strong>Servicio:</strong> <?= ucfirst(str_replace('_', ' ', $servicio)); ?>
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
                                <strong>Precio Total:</strong> Gs. <?= number_format($costo, 0, ',', '.'); ?>
                                <i class='bx bx-check'></i>
                            </li>
                        </ul>
                    </div>
                    <div class="service-faq service-card">
                        <h3 class="service-details-title">Confirmar Reserva</h3>
                        <p>Presiona "Confirmar Reserva" para completar el proceso de reserva de <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $servicio))); ?>.</p>
                        
                        <!-- Botón de Reservar -->
                        <a href="/carrito/agregar?servicio=<?= $servicio; ?>" class="default-btn" style="margin-bottom: 15px;">
                            Reservar
                            <i class="flaticon-right"></i>
                        </a>
                        
                        <!-- Botón de Confirmar Reserva -->
                        <a href="/carrito/confirmar" class="default-btn">
                            Confirmar Reserva
                            <i class="flaticon-right"></i>
                        </a>
                    </div>
                    
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
                                                        Is Reception Open 24 Hours?
                                                    </a>
                                                    <p class="accordion-content">Lorem ipsum dolor sit amet.</p>
                                                </li>
                                                <li class="accordion-item">
                                                    <a class="accordion-title" href="javascript:void(0)">
                                                        <i class='bx bx-chevron-down'></i>
                                                        Can I Leave My Luggage?
                                                    </a>
                                                    <p class="accordion-content">Lorem ipsum dolor sit amet.</p>
                                                </li>
                                                <li class="accordion-item">
                                                    <a class="accordion-title" href="javascript:void(0)">
                                                        <i class='bx bx-chevron-down'></i>
                                                        Which One Is The Nearest Airport?
                                                    </a>
                                                    <p class="accordion-content">Lorem ipsum dolor sit amet.</p>
                                                </li>
                                                <li class="accordion-item">
                                                    <a class="accordion-title" href="javascript:void(0)">
                                                        <i class='bx bx-chevron-down'></i>
                                                        Can I Rent A Car At The Hotel Nearby?
                                                    </a>
                                                    <p class="accordion-content">Lorem ipsum dolor sit amet.</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


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
                                <i class='bx bx-time'></i>
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
