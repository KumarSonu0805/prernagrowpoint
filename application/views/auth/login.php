<link rel="stylesheet" href="<?= file_url('includes/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
            <div class="login-box">
                <!-- /.login-logo -->
                <div class="card card-outline card-oflep">
                    <div class="card-header text-center">
                    <a href="<?= base_url(); ?>" class="h1"><img src="<?= file_url('assets/images/logo.png') ?>" alt="<?= PROJECT_NAME ?> Logo" class="img-fluid"></a>
                    </div>
                    <div class="card-body">
                        <p class="login-box-msg">Sign in to start your session</p>
                        <?= form_open('login/validatelogin'); ?>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-danger text-center mb-2"><?= $this->session->flashdata('logerr'); ?></div>
                            <div class="row">
                                <div class="col-8 d-none">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember">
                                        Remember Me
                                        </label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <button type="submit" name="login" class="btn btn-oflep btn-block">Sign In</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        <?= form_close(); ?>

                        <p class="mb-1 d-none">
                            <a href="<?= base_url('forgot-password/'); ?>">I forgot my password</a>
                        </p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.login-box -->
