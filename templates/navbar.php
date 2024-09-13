<?php $variable = true; ?>
<!doctype html>
<html lang="es">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap Min CSS -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<!--este para mi que esta al pedo Owl Theme Default Min CSS -->
	<link rel="stylesheet" href="../assets/css/owl.theme.default.min.css">
	<!-- Owl Carousel Min CSS -->
	<link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
	<!-- Boxicons Min CSS -->
	<link rel="stylesheet" href="../assets/css/boxicons.min.css">
	<!-- Flaticon CSS -->
	<link rel="stylesheet" href="../assets/css/flaticon.css">
	<!-- Meanmenu Min CSS -->
	<link rel="stylesheet" href="../assets/css/meanmenu.min.css">
	<!-- Animate Min CSS -->
	<link rel="stylesheet" href="../assets/css/animate.min.css">
	<!-- Nice Select Min CSS -->
	<link rel="stylesheet" href="../assets/css/nice-select.min.css">
	<!-- Odometer Min CSS -->
	<link rel="stylesheet" href="../assets/css/odometer.min.css">
	<!-- Date Picker CSS-->
	<link rel="stylesheet" href="../assets/css/date-picker.min.css">
	<!-- Magnific Popup Min CSS -->
	<link rel="stylesheet" href="../assets/css/magnific-popup.min.css">
	<!-- Beautiful Fonts CSS -->
	<link rel="stylesheet" href="../assets/css/beautiful-fonts.css">
	<!-- Style CSS -->
	<link rel="stylesheet" href="../assets/css/style.css">
	<!-- Dark CSS -->
	<link rel="stylesheet" href="../assets/css/dark.css">
	<!-- Responsive CSS -->
	<link rel="stylesheet" href="../assets/css/responsive.css">

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="../assets/img/logooooo.jpg">

	<!-- TITLE -->
	<title>Castillo</title>
</head>

<body>

	<div class="preloader">
		<div class="lds-ripple">
			<div></div>
			<div></div>
		</div>
	</div>

	<!-- Start Ecorik Navbar Area -->
	<div class="eorik-nav-style fixed-top">
		<div class="navbar-area">
			<!-- Menu For Desktop Device -->
			<div class="main-nav">
				<nav class="navbar navbar-expand-md navbar-light">
					<div class="container">
						<a class="navbar-brand" href="/index.php">
							<img src="/assets/img/logo2.png" alt="Logo" style="width: 140px; height:60px;">
						</a>
						<div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
							<ul class="navbar-nav m-auto">
								<li class="nav-item">
									<a href="/index.php">Inicio</a>
								</li>
								<li class="nav-item">
									<a href="/servicios/habitaciones.php" class="nav-link dropdown-toggle">
										Habitaciones
									</a>
								</li>
								<li class="nav-item">
									<a href="/servicios/pasareldia.php">Pasar el día</a>
								</li>
								<li class="nav-item">
									<a href="/servicios/camping.php">Camping</a>
								</li>
								<li class="nav-item">
									<a href="#">Contacto</a>
								</li>
							</ul>
							<!-- Start Other Option -->
							<div class="others-option">
								<ul class="navbar-nav m-auto">
									<li class="nav-item">
										<?php if ($variable): ?>
											<!-- Si la variable es true, solo muestra el enlace de "Iniciar sesión" -->
											<a href="/auth/login.php" class="nav-link">Iniciar sesión</a>
										<?php else: ?>
											<!-- Si la variable es false, muestra el enlace con el menú desplegable -->
											<a href="#" class="nav-link dropdown-toggle">
												Mi cuenta
												<i class='bx bx-chevron-down'></i> <!-- Icono de flecha -->
											</a>
											<ul class="dropdown-menu">
												<li class="nav-item">
													<a href="profile.html" class="nav-link">Mi cuenta</a> <!-- Modifica la URL según tu necesidad -->
												</li>
												<li class="nav-item">
													<a href="reservations.html" class="nav-link">Mis reservas</a>
												</li>
												<li class="nav-item">
													<a href="cart.html" class="nav-link">Carrito</a>
												</li>
												<li class="nav-item">
													<a href="admin.html" class="nav-link">Admin</a>
												</li>
											</ul>
										<?php endif; ?>
									</li>
								</ul>
							</div>

							<!-- End Other Option -->
						</div>
					</div>
				</nav>
			</div>
		</div>
	</div>
	<!-- End Ecorik Navbar Area -->