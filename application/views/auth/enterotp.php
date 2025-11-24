
            <div class="login-box">
                <div class="card card-outline card-oflep">
                    <div class="card-header text-center">
                    <a href="<?= base_url(); ?>" class="h1"><img src="<?= file_url('assets/images/logo.png') ?>" alt="<?= PROJECT_NAME ?> Logo" class="img-fluid"></a>
                    </div>
                    <div class="card-body">
                        <p class="login-box-msg">Enter OTP to Reset your Password now.</p>
                        <?= form_open('login/validateOTP/'); ?>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="OTP" name="otp">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-danger text-center mb-2"><?= $this->session->flashdata('logerr'); ?></div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" name="submitotp" class="btn btn-oflep btn-block">Change password</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        <?= form_close() ?>

                        <p class="mt-3 mb-1">
                            <a href="<?= base_url('login/'); ?>">Login</a>
                        </p>
                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
            <!-- /.login-box -->