<?php include __DIR__ . "/../../templates/navbar.php"; ?>

<br>

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
                                    <div class="input-group date">
                                        <i class="flaticon-calendar"></i>
                                        <input type="text" id="fechaEntradaDisponibilidad" class="form-control" name="fecha_entrada" placeholder="Entrada" value="<?= htmlspecialchars($_GET['fecha_entrada'] ?? ''); ?>">
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
                                        <input type="text" id="fechaSalidaDisponibilidad" class="form-control" name="fecha_salida" placeholder="Salida" value="<?= htmlspecialchars($_GET['fecha_salida'] ?? ''); ?>">
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
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <option value="<?= $i ?>" <?= (isset($_GET['adult']) && $_GET['adult'] == $i) ? 'selected' : '' ?>><?= str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                                <?php endfor; ?>
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
		<br><br>
        <!-- Sección para mostrar las habitaciones disponibles -->
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
                                
                                <!-- Botones de Reservar y Añadir al Carrito -->
                                <div class="d-flex justify-content-between">
                                    <!-- Botón de Reservar -->
                                    <a href="#" class="default-btn" onclick="redireccionarConDatos(event, '<?= $habitacion['id_habitacion'] ?>')">
                                        Reservar
                                        <i class="flaticon-right"></i>
                                    </a>

                                    <script>
                                        function redireccionarConDatos(event, habitacionId) {
                                            event.preventDefault();

                                            const fechaEntrada = document.getElementById('fechaEntradaDisponibilidad').value;
                                            const fechaSalida = document.getElementById('fechaSalidaDisponibilidad').value;
                                            const adultos = document.querySelector('select[name="adult"]').value;

                                            if (fechaEntrada && fechaSalida && adultos) {
                                                // Redirigir a la URL de confirmación con los datos como parámetros
                                                window.location.href = `/confirmacionReserva?servicio=habitacion&id_habitacion=${habitacionId}&fecha_entrada=${encodeURIComponent(fechaEntrada)}&fecha_salida=${encodeURIComponent(fechaSalida)}&adultos=${adultos}`;
                                            } else {
                                                alert("Por favor, completa todos los campos.");
                                            }
                                        }
                                    </script>

                                    <!-- Botón de Añadir al Carrito -->
                                    <form action="/carrito/agregar" method="POST" style="display: inline;">
                                        <input type="hidden" name="id_habitacion" value="<?= $habitacion['id_habitacion']; ?>">
                                        <input type="hidden" name="fecha_entrada" value="<?= htmlspecialchars($_GET['fecha_entrada'] ?? ''); ?>">
                                        <input type="hidden" name="fecha_salida" value="<?= htmlspecialchars($_GET['fecha_salida'] ?? ''); ?>">
                                        <input type="hidden" name="adultos" value="<?= htmlspecialchars($_GET['adult'] ?? ''); ?>">
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
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fechaEntradaDisponibilidad = document.getElementById('fechaEntradaDisponibilidad');
        const fechaSalidaDisponibilidad = document.getElementById('fechaSalidaDisponibilidad');

        // Configurar fecha de entrada
        flatpickr(fechaEntradaDisponibilidad, {
            minDate: "today",
            dateFormat: "d/m/Y",
            clickOpens: true,
            onChange: function(selectedDates) {
                if (selectedDates.length > 0) {
                    // Configurar fecha mínima para salida a un día después de la entrada
                    fechaSalidaDisponibilidad._flatpickr.set('minDate', new Date(selectedDates[0].getTime() + 24 * 60 * 60 * 1000));
                }
            }
        });

        // Configurar fecha de salida
        flatpickr(fechaSalidaDisponibilidad, {
            minDate: "today",
            dateFormat: "d/m/Y",
            clickOpens: true
        });

        // Inicializar niceSelect para el selector de adultos
        $('select').niceSelect();
    });
</script>

<?php include __DIR__ . "/../../templates/footer.php"; ?>
