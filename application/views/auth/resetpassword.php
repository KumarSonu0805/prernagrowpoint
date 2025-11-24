
            <div class="login-box">
                <div class="card card-outline card-oflep">
                    <div class="card-header text-center">
                    <a href="<?= base_url(); ?>" class="h1"><img src="<?= file_url('assets/images/logo.png') ?>" alt="<?= PROJECT_NAME ?> Logo" class="img-fluid"></a>
                    </div>
                    <div class="card-body">
                        <p class="login-box-msg">Enter you new Password</p>
                        <?= form_open('login/changepassword','onSubmit="return validate()"'); ?>
                            <div class="input-group mb-3">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="confirm" placeholder="Confirm Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-oflep btn-block">Change password</button>
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

            <script>
                function validate(){
                    if($('#password').val()!=$('#confirm').val()){
                        alert("Passwords Do not Match!");
                        return false;
                    }
                }
            </script>