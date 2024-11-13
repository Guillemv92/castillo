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
                <form id="disponibilidadForm" class="check-form">
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
        <div id="habitaciones-disponibles">
            <?php include __DIR__ . '/partials/_habitaciones_disponibles.php'; ?>
        </div>
    </div>
</section>

<script>
    function redireccionarConDatos(event, habitacionId) {
        event.preventDefault();

        const fechaEntrada = document.getElementById('fechaEntradaDisponibilidad').value;
        const fechaSalida = document.getElementById('fechaSalidaDisponibilidad').value;
        const adultos = document.querySelector('select[name="adult"]').value;

        if (fechaEntrada && fechaSalida && adultos) {
            window.location.href = `/confirmacionReserva?servicio=habitacion&id_habitacion=${habitacionId}&fecha_entrada=${encodeURIComponent(fechaEntrada)}&fecha_salida=${encodeURIComponent(fechaSalida)}&adultos=${adultos}`;
        } else {
            alert("Por favor, completa todos los campos.");
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const fechaEntradaDisponibilidad = document.getElementById('fechaEntradaDisponibilidad');
        const fechaSalidaDisponibilidad = document.getElementById('fechaSalidaDisponibilidad');

        // Configurar flatpickr con validación de fechas
        flatpickr(fechaEntradaDisponibilidad, {
            minDate: "today",
            dateFormat: "d/m/Y",
            onChange: function(selectedDates) {
                if (selectedDates.length > 0) {
                    fechaSalidaDisponibilidad._flatpickr.set('minDate', new Date(selectedDates[0].getTime() + 24 * 60 * 60 * 1000));
                }
            }
        });

        flatpickr(fechaSalidaDisponibilidad, {
            minDate: "today",
            dateFormat: "d/m/Y"
        });

        // Configurar el formulario para AJAX
        document.getElementById('disponibilidadForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const fechaEntrada = fechaEntradaDisponibilidad.value;
            const fechaSalida = fechaSalidaDisponibilidad.value;
            const adultos = document.querySelector('select[name="adult"]').value;

            fetch(`/verificarDisponibilidad?fecha_entrada=${encodeURIComponent(fechaEntrada)}&fecha_salida=${encodeURIComponent(fechaSalida)}&adult=${encodeURIComponent(adultos)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('habitaciones-disponibles').innerHTML = data.html;
            })
            .catch(error => console.error('Error en la solicitud AJAX:', error));
        });
    });
</script>

<?php include __DIR__ . "/../../templates/footer.php"; ?>
