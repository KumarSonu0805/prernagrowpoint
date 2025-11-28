<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Prernagrowpoint - Register</title>
      <?php $this->load->view("website/common/include"); ?>
   </head>
   <body>
      <?php $this->load->view("website/common/navbar"); ?>
     <section class="register-section">
   <div class="container">
      <div class="register-box">

       <div class="row">
        <div class="col-lg-6">
  <h2 class="register-title">Create Your Account</h2>
         <p class="register-subtitle">Join Prernagrowpoint and start your journey today!</p>

         <form>

            <div class="mb-3">
               <label class="form-label">Full Name</label>
               <input type="text" class="form-control reg-input" placeholder="Enter your full name">
            </div>

            <div class="mb-3">
               <label class="form-label">Email Address</label>
               <input type="email" class="form-control reg-input" placeholder="name@example.com">
            </div>

            <div class="mb-3">
               <label class="form-label">Mobile Number</label>
               <input type="text" class="form-control reg-input" placeholder="Enter mobile number">
            </div>

            <div class="mb-3">
               <label class="form-label">Password</label>
               <input type="password" class="form-control reg-input" placeholder="******">
            </div>

            <div class="mb-3">
               <label class="form-label">Confirm Password</label>
               <input type="password" class="form-control reg-input" placeholder="******">
            </div>

            <button type="submit" class="register-btn">Register</button>

            <p class="login-text">
               Already have an account? <a href="../login/" class="login-link">Login here</a>
            </p>

         </form>
        </div>
        <div class="col-lg-6">
 <div class="loginimg">
                    <img src="../images/register.webp" alt="login image">
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