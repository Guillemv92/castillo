<?php include __DIR__ . "/../../templates/navbar.php"; ?>

<br><br>

<section class="news-area ptb-100">
    <div class="container">
        <div id="titulo-habitaciones">
            <h1>Habitaciones disponibles</h1>
        </div>

        <!-- Formulario de búsqueda justo debajo del título -->
        <div id="habitaciones-form">
            <div class="container">
				<form class="check-form" action="/disponibilidad" method="GET">
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

						<div class="col-lg-3 col-sm-6">
							<div class="check-content">
								<p>Fecha de salida</p>
								<div class="form-group">
									<div class="input-group date" id="datetimepicker-2">
										<i class="flaticon-calendar"></i>
										<input type="text" class="form-control" placeholder="29/02/2020" name="fecha_salida">
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
									Ver habitaciones
									<i class="flaticon-right"></i>
								</button>
							</div>
						</div>
					</div>
                </form>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($habitacionesDisponibles)): ?>
                <?php foreach ($habitacionesDisponibles as $habitacion): ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="single-news">
                            <div class="news-img">
								<img src="/assets/img/<?= htmlspecialchars($habitacion['nombre']); ?>-disponibilidad.jpg" alt="Image">
                                <div class="dates">
                                    <span>Gs. <?= htmlspecialchars($habitacion['precio']); ?></span>
                                </div>
                            </div>
                            <div class="news-content-wrap">
                                <h3><?= htmlspecialchars($habitacion['nombre']); ?></h3>
                                <p>🚿 Baño ❄️ Aire acondicionado 🧼 Jabón 🧺 Toallas</p>
                                <p><strong>Precio: Gs. <?= htmlspecialchars($habitacion['precio']); ?></strong></p>
                                <a class="read-more" href="/reservar?habitacion=<?= htmlspecialchars($habitacion['id_habitacion']); ?>">
                                    Reservar <i class="flaticon-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay habitaciones disponibles para las fechas seleccionadas.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . "/../../templates/footer.php"; ?>
