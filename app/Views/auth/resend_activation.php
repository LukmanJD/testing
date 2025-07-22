<?= $this->extend('auth/index'); ?>

<?= $this->section('content'); ?>
<div class="row justify-content-center align-items-center h-100" style="background-color: #2d499d">
    <div class="col-xl-4 col-lg-5 col-10">
        <div class="card mt-3">
            <div class="card-content">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="<?= base_url(); ?>"><img src="<?= base_url('media/icon/logo.svg'); ?>" alt="Logo" /></a>
                    </div>
                    <h1 class="auth-title text-center">Resend Activation</h1>
                    <p class="auth-subtitle mb-4 text-center">
                        Enter your email and we will send you a new activation link.
                    </p>
                    <?= view('Myth\Auth\Views\_message_block') ?>

                    <form action="<?= site_url('register/resend') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input
                                type="text"
                                class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                                placeholder="<?= lang('Auth.email') ?>"
                                name="email"
                                value="<?= old('email') ?>" />
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block shadow mt-4" type="submit">
                            Resend Activation Link
                        </button>
                    </form>

                    <div class="text-center mt-4 text-lg">
                        <p class="text-gray-600">
                            Your Account Already Active?
                            <a class="font-bold" href="<?= route_to('login') ?>"><?= lang('Auth.signIn') ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>