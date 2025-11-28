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
                <h2 class="login-title">Registered Successfully</h2>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <h4>Welcome <?php echo $this->session->flashdata('mname'); ?>,</h4><br>
                        <ul style="list-style:none;">
                            <li><h4>Username : <?php echo $this->session->flashdata('uname');?></h4><br></li>
                            <li><h4>Password : <?php echo $this->session->flashdata('pass');?></h4></li>
                        </ul>
                    </div>
                </div>
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