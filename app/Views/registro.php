<?php include __DIR__ . "/../../templates/navbar.php"; ?>

<section class="user-area-all-style register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="contact-form-action">
                    <div class="form-heading text-center">
                        <h3 class="form-title">Crea tu cuenta</h3>
                        <p class="form-desc">Completa el formulario para registrarte.</p>
                    </div>
                    <form method="post" action="/procesarRegistro">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="nombre" placeholder="Nombre" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="apellido" placeholder="Apellido" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" type="email" name="email" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="telefono" placeholder="Teléfono" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="cedula" placeholder="Cédula" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" type="password" name="contrasenha" placeholder="Contraseña" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="default-btn btn-two" type="submit">
                                    Registrarse
                                    <i class="flaticon-right"></i>
                                </button>
                            </div>
                            <div class="col-12">
                                <p class="account-desc">
                                    ¿Ya tienes cuenta?
                                    <a href="/login">Inicia sesión</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . "/../../templates/footer.php"; ?>
