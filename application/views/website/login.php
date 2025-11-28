<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Prernagrowpoint - Login</title>
      <?php $this->load->view("website/common/include"); ?>
   </head>
   <body>
      <?php $this->load->view("website/common/navbar"); ?>
     <section class="login-section">
   <div class="container">
      <div class="login-box">

         

        <div class="row">
            <div class="col-lg-6">
                <h2 class="login-title">Login to Your Account</h2>
         <p class="login-subtitle">Welcome back! Please enter your details.</p>
                 <?= form_open('login/validatelogin'); ?>
            <div class="mb-3">
               <label class="form-label">Username</label>
               <input type="text" name="username" placeholder="Username" class="form-control login-input">
            </div>

            <div class="mb-3">
               <label class="form-label">Password</label>
               <input type="password" name="password" class="form-control login-input" placeholder="******">
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 d-none">
               <div class="form-check">
                 <input class="form-check-input" type="checkbox" id="remember">
                 <label class="form-check-label" for="remember">Remember Me</label>
               </div>
               <a href="#" class="forgot-link d-none">Forgot Password?</a>
            </div>

            <button type="submit" class="login-btn">Login</button>

            <p class="register-text">
               Don’t have an account? <a href="../register/" class="register-link">Register Now</a>
            </p>
              <?= form_close(); ?>
            </div>
            <div class="col-lg-6">
                <div class="loginimg">
                    <img src="../images/loginform.webp" alt="login image">
                </div>
            </div>
        </div>

      </div>
   </div>
</section>

  
      <?php $this->load->view("website/common/footer"); ?>
      <?php $this->load->view("website/common/vendor"); ?>
   </body>
</html>