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
    <div class="container">
        <form class="check-form" action="/procesarReserva" method="POST">
            <div class="row align-items-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="check-content">
                        <p>Fecha de entrada</p>
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker-1">
                                <i class="flaticon-calendar"></i>
                                <input type="text" class="form-control" placeholder="29/02/2020" name="fecha_entrada">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th"></i>
                                </span>
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
                            Reservar
                            <i class="flaticon-right"></i>
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<?php include __DIR__ . "/../../templates/footer.php"; ?>
