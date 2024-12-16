<?php include __DIR__ . "/../../templates/navbar.php"; ?>

<section class="user-area-all-style log-in-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="contact-form-action">
                    <div class="form-heading text-center">
                        <h3 class="form-title">¡Inicia sesión en tu cuenta!</h3>
                    </div>
                    <form method="post" action="/procesarLogin">
                        <div class="row">
                            <div class="col-12">
                                <?php if (!empty($error)): ?>
                                    <p style="color: red;"><?= $error ?></p>
                                <?php endif; ?>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="name" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" type="password" name="password" placeholder="Contraseña">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 form-condition">
                                <div class="agree-label">
                                    <input type="checkbox" id="chb1">
                                    <label for="chb1">
                                        Recuérdame
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <a class="forget" href="recover-password.html">¿Olvidaste tu contraseña?</a>
                            </div>
                            <div class="col-12">
                                <button class="default-btn btn-two" type="submit">
                                    Iniciar Sesión
                                    <i class="flaticon-right"></i>
                                </button>
                            </div>
                            <div class="col-12">
                                <p class="account-desc">
                                    ¿No tienes una cuenta?
                                    <a href="/registro">Regístrate</a>
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
