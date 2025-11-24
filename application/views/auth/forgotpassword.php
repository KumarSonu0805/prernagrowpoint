
            <div class="login-box">
                <div class="card card-outline card-oflep">
                    <div class="card-header text-center">
                    <a href="<?= base_url(); ?>" class="h1"><img src="<?= file_url('assets/images/logo.png') ?>" alt="<?= PROJECT_NAME ?> Logo" class="img-fluid"></a>
                    </div>
                    <div class="card-body">
                        <p class="login-box-msg">You forgot your password? Here you can easily reset your password.</p>
                        <?= form_open('login/validateuser'); ?>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Username" name="username">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" name="forgotpassword" class="btn btn-oflep btn-block">Reset password</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        <?= form_close(); ?>
                        <p class="mt-3 mb-1">
                            <a href="<?= base_url('login/'); ?>">Login</a>
                        </p>
                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
            <!-- /.login-box -->