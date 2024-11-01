<?php include __DIR__ . "/../../templates/navbar.php"; ?>

<section class="eorik-slider-area">
    <div class="eorik-slider owl-carousel owl-theme">
        <div class="eorik-slider-item slider-item-bg-2">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container">
                        <div class="eorik-slider-text overflow-hidden two eorik-slider-text-one">
                            <h1>Veni a Pasar el Dia</h1>
                            <span>Discover the place where you have fun & enjoy a lot</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="white-shape">
        <img src="../assets/img/home-one/slider/white-shape.png" alt="Image">
    </div>
</section>

<div class="check-area mb-minus-10">
    <div class="container container-dia">
        <form class="check-form" action="/pasareldia/agregarAlCarrito" method="POST">
            <div class="row align-items-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="check-content">
                        <p>Fecha de entrada</p>
                        <div class="form-group">
                            <div class="input-group date">
                                <i class="flaticon-calendar"></i>
                                <input type="text" id="fechaEntradaPasarDia" class="form-control" name="fecha_entrada" placeholder="Fecha de Entrada">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="check-content">
                        <p>Adultos</p>
                        <div class="form-group">
                            <select name="adult" class="form-content">
                                <option value="1">01</option>
                                <option value="2">02</option>
                                <option value="3">03</option>
                                <option value="4">04</option>
                                <option value="5">05</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="check-btn check-content mb-0 d-flex justify-content-between">
                        <!-- Botón para ir a la página de confirmación con datos en la URL -->
                        <a href="#" class="default-btn" onclick="redireccionarConDatos(event)">
                            Reservar
                            <i class="flaticon-right"></i>
                        </a>

                        <script>
                            function redireccionarConDatos(event) {
                                event.preventDefault();

                                const fechaEntrada = document.getElementById('fechaEntradaPasarDia').value;
                                const adultos = document.querySelector('select[name="adult"]').value;

                                if (fechaEntrada && adultos) {
                                    // Redirigir a la URL con los datos como parámetros
                                    window.location.href = `/confirmacionReserva?servicio=pasar_el_dia&fecha_entrada=${encodeURIComponent(fechaEntrada)}&adultos=${adultos}`;
                                } else {
                                    alert("Por favor, completa todos los campos.");
                                }
                            }
                        </script>
                        <!-- Botón para añadir al carrito -->
                        <button type="submit" class="default-btn" style="background-color: #28a745;">
                            Añadir al Carrito
                            <i class="flaticon-cart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Script para el calendario y el selector de adultos -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inicializar el selector de adultos con niceSelect
        $('select').niceSelect();

        // Configuración de la fecha de entrada
        flatpickr("#fechaEntradaPasarDia", {
            minDate: "today",
            dateFormat: "d/m/Y"
        });
    });
</script>

<?php include __DIR__ . "/../../templates/footer.php"; ?>
