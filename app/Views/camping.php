<?php include __DIR__ . "/../../templates/navbar.php"; ?>

<section class="eorik-slider-area">
    <div class="eorik-slider owl-carousel owl-theme">
        <div class="eorik-slider-item slider-item-bg-3">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container">
                        <div class="eorik-slider-text overflow-hidden three eorik-slider-text-one">
                            <h1>Te animas a Acampar?</h1>
                            <span>Discover the place where you have fun & enjoy a lot</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="white-shape">
        <img src="/assets/img/home-one/slider/white-shape.png" alt="Image">
    </div>
</section>

<!-- Start Check Area -->
<div class="check-area mb-minus-10">
    <div class="container">
        <!-- Cambiar el método a POST -->
        <form class="check-form" action="/procesarCampingReserva" method="POST">
            <div class="row align-items-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="check-content">
                        <p>Fecha de entrada</p>
                        <div class="form-group">
                            <div class="input-group date">
                                <i class="flaticon-calendar"></i>
                                <input type="text" id="fechaEntradaCamping" class="form-control" name="fecha_entrada" placeholder="Entrada" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="check-content">
                        <p>Fecha de salida</p>
                        <div class="form-group">
                            <div class="input-group date">
                                <i class="flaticon-calendar"></i>
                                <input type="text" id="fechaSalidaCamping" class="form-control" name="fecha_salida" placeholder="Salida" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="check-content">
                                <p>Adultos</p>
                                <div class="form-group">
                                    <select name="adult" class="form-content" required>
                                        <option value="1">01</option>
                                        <option value="2">02</option>
                                        <option value="3">03</option>
                                        <option value="4">04</option>
                                        <option value="5">05</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="check-btn check-content mb-0 d-flex justify-content-between">
                        <!-- Botón para ir a la página de confirmación directamente -->
                        <button type="submit" name="action" value="reservar" class="default-btn">
                            Reservar
                            <i class="flaticon-right"></i>
                        </button>

                        <!-- Botón para añadir al carrito -->
                        <button type="submit" name="action" value="carrito" class="default-btn" style="background-color: #28a745;">
                            Añadir al Carrito
                            <i class="flaticon-cart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End Check Section -->

<!-- Script para el calendario y el selector de adultos -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('select').niceSelect();

        const fechaEntradaCamping = document.getElementById('fechaEntradaCamping');
        const fechaSalidaCamping = document.getElementById('fechaSalidaCamping');

        flatpickr(fechaEntradaCamping, {
            minDate: "today",
            dateFormat: "d/m/Y",
            onChange: function(selectedDates) {
                if (selectedDates.length > 0) {
                    fechaSalidaCamping._flatpickr.set('minDate', new Date(selectedDates[0].getTime() + 24 * 60 * 60 * 1000));
                }
            }
        });

        flatpickr(fechaSalidaCamping, {
            minDate: "today",
            dateFormat: "d/m/Y"
        });
    });
</script>

<?php include __DIR__ . "/../../templates/footer.php"; ?>
