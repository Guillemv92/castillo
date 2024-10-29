<?php include "../templates/navbar.php"; ?>

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
            <!-- Resto del formulario de HTML -->
            <button type="submit" class="default-btn">
                Reservar
                <i class="flaticon-right"></i>
            </button>
        </form>
    </div>
</div>

<?php include "../templates/footer.php"; ?>
