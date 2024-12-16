<div class="row" id="habitaciones-disponibles">
    <?php if (!empty($habitacionesDisponibles)): ?>
        <?php foreach ($habitacionesDisponibles as $habitacion): ?>
            <div class="col-lg-6 col-md-6">
                <div class="single-news">
                    <div class="news-img">
                        <img src="/assets/img/habitaciones/<?= htmlspecialchars($habitacion['nombre']); ?>-disponibilidad.jpg" alt="Image">
                    </div>
                    <div class="news-content-wrap">
                        <h3><?= htmlspecialchars($habitacion['nombre']); ?></h3>
                        <p>🚿 Baño ❄️ Aire acondicionado 🧼 Jabón 🧺 Toallas</p>
                        <p><strong>Precio: Gs. <?= htmlspecialchars($habitacion['precio']); ?></strong></p>
                        
                        <div class="d-flex justify-content-between">
                            <a href="#" class="default-btn" onclick="redireccionarConDatos(event, '<?= $habitacion['id_habitacion'] ?>')">
                                Reservar
                                <i class="flaticon-right"></i>
                            </a>

                            <form action="/carrito/agregar" method="POST" style="display: inline;">
                                <input type="hidden" name="id_habitacion" value="<?= $habitacion['id_habitacion']; ?>">
                                <input type="hidden" name="fecha_entrada" value="<?= htmlspecialchars($fechaEntrada); ?>">
                                <input type="hidden" name="fecha_salida" value="<?= htmlspecialchars($fechaSalida); ?>">
                                <input type="hidden" name="adultos" value="<?= htmlspecialchars($adultos); ?>">
                                <button type="submit" class="default-btn" style="background-color: #28a745;">
                                    Añadir al Carrito
                                    <i class="flaticon-cart"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay habitaciones disponibles para las fechas seleccionadas.</p>
    <?php endif; ?>
</div>
