<?php include("../templates/navbar.php"); ?>

<br><br>

<!-- End News Area -->
<section class="news-area ptb-100">
	<div class="container">
		<div id="titulo-habitaciones">
			<h1>Habitaciones disponibles</h1>
		</div>

		<!-- Formulario de búsqueda justo debajo del título -->
		<div id="habitaciones-form">
			<div class="container" >
				<form class="check-form" action="disponibilidad.php" method="GET">
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

			<div class="col-lg-6 col-md-6">
				<div class="single-news">
					<div class="news-img">
						<img src="../assets/img/matri1-disponibilidad.jpg" alt="Image">
						<div class="dates">
							<span>Gs. 260.000</span>
						</div>
					</div>
					<div class="news-content-wrap">
						<a href="news-details.html">
							<h3>Habitacion matrimonial 1</h3>
						</a>
						<p>
							🚿 Baño
							❄️ Aire acondicionado
							🧼 Jabón
							🧺 Toallas <br>
							🕛 Check-in: 14:00hs
							🕚Check-out: 11:00hs (del día siguiente)
							<br>
						<p style="font-size: 24px; font-weight: bold; color: black;">
							Precio: Gs. 260.000
						</p>
						</p>

						<a class="read-more" href="news-details.html">
							Reservar
							<i class="flaticon-right"></i>
						</a>
						<br>
						<a class="read-more" href="news-details.html">
							Añadir al carrito
							<i class="flaticon-right"></i>
						</a>

					</div>
				</div>
			</div>



			<div class="col-lg-6 col-md-6">
				<div class="single-news">
					<div class="news-img">
						<img src="../assets/img/matri2-disponibilidad.jpeg" alt="Image">
						<div class="dates">
							<span>Gs. 260.000</span>
						</div>
					</div>
					<div class="news-content-wrap">
						<a href="news-details.html">
							<h3>Habitacion matrimonial 2</h3>
						</a>
						<p>
							🚿 Baño
							❄️ Aire acondicionado
							🧼 Jabón
							🧺 Toallas <br>
							🕛 Check-in: 14:00hs
							🕚Check-out: 11:00hs (del día siguiente)
						</p>
						<a class="read-more" href="news-details.html">
							Reservar
							<i class="flaticon-right"></i>
						</a>
						<br>
						<a class="read-more" href="news-details.html">
							Añadir al carrito
							<i class="flaticon-right"></i>
						</a>
					</div>
				</div>
			</div>



			<div class="col-lg-6 col-md-6">
				<div class="single-news">
					<div class="news-img">
						<img src="../assets/img/triple-disponibilidad.jpg" alt="Image">
						<div class="dates">
							<span>Gs. 330.000</span>
						</div>
					</div>
					<div class="news-content-wrap">
						<a href="news-details.html">
							<h3>Habitacion triple</h3>
						</a>
						<p>
							🚿 Baño
							❄️ Aire acondicionado
							🧼 Jabón
							🧺 Toallas <br>
							🕛 Check-in: 14:00hs
							🕚Check-out: 11:00hs (del día siguiente)
						</p>
						<a class="read-more" href="news-details.html">
							Reservar
							<i class="flaticon-right"></i>
						</a>
						<br>
						<a class="read-more" href="news-details.html">
							Añadir al carrito
							<i class="flaticon-right"></i>
						</a>
					</div>
				</div>
			</div>



			<div class="col-lg-6 col-md-6">
				<div class="single-news">
					<div class="news-img">
						<img src="../assets/img/cuadruple-disponibilidad.jpg" alt="Image">
						<div class="dates">
							<span>Gs. 390.000</span>
						</div>
					</div>
					<div class="news-content-wrap">
						<a href="news-details.html">
							<h3>Habitacion cuadruple</h3>
						</a>
						<p>
							🚿 Baño
							❄️ Aire acondicionado
							🧼 Jabón
							🧺 Toallas <br>
							🕛 Check-in: 14:00hs
							🕚Check-out: 11:00hs (del día siguiente)
						</p>
						<a class="read-more" href="news-details.html">
							Reservar
							<i class="flaticon-right"></i>
						</a>
						<br>
						<a class="read-more" href="news-details.html">
							Añadir al carrito
							<i class="flaticon-right"></i>
						</a>
					</div>
				</div>
			</div>


		</div>
	</div>
</section>
<!-- End News Area -->


<?php include("../templates/footer.php"); ?>