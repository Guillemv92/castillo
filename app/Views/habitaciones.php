<?php include __DIR__ . "/../../templates/navbar.php"; ?>

<section class="eorik-slider-area">
    <div class="eorik-slider owl-carousel owl-theme">
        <div class="eorik-slider-item slider-item-bg-1">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container">
                        <div class="eorik-slider-text overflow-hidden one eorik-slider-text-one">
                            <h1>Alojate en el Castillo</h1>
                            <span>Discover the place where you have fun & enjoy a lot</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="white-shape">
        <img src="../../assets/img/otros/white-shape.png" alt="Image">
    </div>
</section>
<!-- Start Check Area -->
<div class="check-area mb-minus-10">
    <div class="container">
        <form class="check-form" action="/disponibilidad" method="GET">
            <div class="row align-items-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="check-content">
                        <p>Fecha de entrada</p>
                        <div class="form-group">
                            <div class="input-group date">
                                <i class="flaticon-calendar"></i>
                                <input type="text" id="fechaEntrada" class="form-control" name="fecha_entrada" placeholder="Entrada">
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
                                <input type="text" id="fechaSalida" class="form-control" name="fecha_salida" placeholder="Salida">
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
                    </div>
                </div>
                
                <div class="col-lg-3">
                    <div class="check-btn check-content mb-0">
                        <button type="submit" class="default-btn">
                            Ver habitaciones
                            <i class="flaticon-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End Check Section -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fechaEntrada = document.getElementById('fechaEntrada');
        const fechaSalida = document.getElementById('fechaSalida');

        // Configurar fecha de entrada
        flatpickr(fechaEntrada, {
            minDate: "today",
            dateFormat: "d/m/Y",
            onChange: function(selectedDates) {
                if (selectedDates.length > 0) {
                    // Configurar fecha mínima para salida a un día después de la entrada
                    fechaSalida._flatpickr.set('minDate', new Date(selectedDates[0].getTime() + 24 * 60 * 60 * 1000));
                }
            }
        });

        // Configurar fecha de salida
        flatpickr(fechaSalida, {
            minDate: "today",
            dateFormat: "d/m/Y"
        });

        // Inicializar niceSelect para el selector de adultos
        $('select').niceSelect();
    });
</script>

<?php include __DIR__ . "/../../templates/footer.php"; ?>
