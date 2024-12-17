<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();  // Inicia la sesión si aún no está iniciada
} else {
    // La sesión ya está iniciada, no se hace nada
    // O puedes agregar un comentario aquí si prefieres
}
?>
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
	<!-- Flatpickr CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<!-- Flatpickr JS -->
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="/assets/img/templates/logooooo.jpg">

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
							<img src="/assets/img/templates/logo2.png" alt="Logo" style="width: 140px; height:60px;">
						</a>
						<div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
							<ul class="navbar-nav m-auto">
								<li class="nav-item">
									<a href="/index.php">Inicio</a>
								</li>
								<li class="nav-item">
									<a href="/habitaciones" class="nav-link dropdown-toggle">
										Habitaciones
									</a>
								</li>
								<li class="nav-item">
									<a href="/pasareldia">Pasar el día</a>
								</li>
								<li class="nav-item">
									<a href="/camping">Camping</a>
								</li>
								<li class="nav-item">
									<a href="#">Contacto</a>
								</li>
							</ul>
							<!-- Start Other Option -->
							<div class="others-option">
								<ul class="navbar-nav m-auto">
									<li class="nav-item">
										<?php if (!isset($_SESSION['user'])): ?>
											<!-- Si la variable es true, solo muestra el enlace de "Iniciar sesión" -->
											<a href="/login" class="nav-link">Iniciar sesión</a>
										<?php else: ?>
											<!-- Si la variable es false, muestra el enlace con el menú desplegable -->
											<a href="#" class="nav-link dropdown-toggle">
												Mi cuenta
												<i class='bx bx-chevron-down'></i> <!-- Icono de flecha -->
											</a>
											<ul class="dropdown-menu">
												<li class="nav-item">
													<a href="profile.html" class="nav-link">Mi cuenta</a> 
												</li>
												<li class="nav-item">
													<a href="/misReservas" class="nav-link">Mis reservas</a>
												</li>
												<li class="nav-item">
    												<a href="/carrito" class="nav-link">Carrito</a>
												</li>
												<li class="nav-item">
                                                <a href="/logout" class="nav-link">Cerrar sesión</a> <!-- Opción para cerrar sesión -->
                                            	</li>
												<?php if (isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] === 'A'): ?>
    												<li class="nav-item">
        											<a href="/admin" class="nav-link">Admin</a>
    												</li>
												<?php endif; ?>
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
