<?php include __DIR__ . "/../../templates/navbar.php"; ?>

<section class="user-area-all-style log-in-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="contact-form-action">
                    <div class="form-heading text-center">
                        <h3 class="form-title">Login to your account!</h3>
                        <p class="form-desc">With your social network.</p>
                    </div>
                    <form method="post" action="/procesarLogin">
                        <div class="row">
                            <div class="col-12">
                                <?php if (!empty($error)): ?>
                                    <p style="color: red;"><?= $error ?></p>
                                <?php endif; ?>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="name" placeholder="Username or Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" type="password" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 form-condition">
                                <div class="agree-label">
                                    <input type="checkbox" id="chb1">
                                    <label for="chb1">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <a class="forget" href="recover-password.html">Forgot my password?</a>
                            </div>
                            <div class="col-12">
                                <button class="default-btn btn-two" type="submit">
                                    Log In Now
                                    <i class="flaticon-right"></i>
                                </button>
                            </div>
                            <div class="col-12">
                                <p class="account-desc">
                                    Not a member?
                                    <a href="/registro">Register</a>
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
