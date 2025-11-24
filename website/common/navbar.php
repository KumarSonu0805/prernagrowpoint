<section class="topsection">
   <div class="container">
      <div class="row">
         <div class="col-lg-8">
            <div class="top-contact">
               <ul>
                  <li>
                     Email: <a href="#">prerngrowpoint@gmail.com</a>
                  </li>
                  <li>
                     Call us : <a href="#">+91-9876543210</a>
                  </li>
               </ul>
            </div>
         </div>
         <div class="col-lg-4">
            <ul class="registerHelping d-lg-flex">
               <li><a href="login.php" class="helpBtn">Login</a></li>
               <li><a href="register.php" class="helpBtn">Register</a></li>
            </ul>
         </div>
      </div>
   </div>
</section>
<nav class="navbar navbar-expand-lg p-0 ElegantNav">
   <div class="container">
      <a class="navbar-brand brand-area" href="index.php">
         <h2 class="company-logo">
            <!-- <span>Prernagrowpoint</span> -->
             <img src="./images/logo.png" alt="logo">
         </h2>
      </a>
     
      <div class="navbartext">
         <div class="offcanvas offcanvas-end ElegantCanvas" id="offcanvasRight">
            <div class="offcanvas-header">
               <h5 class="offcanvas-title">
                  <!-- Prernagrowpoint -->
                   <img src="./images/mobilelogo.png" alt="logo">
               </h5>
               <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
               <ul class="navbar-nav align-items-lg-center">
                  <li class="nav-item">
                     <a class="nav-link <?= strpos($_SERVER['PHP_SELF'],'index.php')!==FALSE?'active':''; ?>" 
                        href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link <?= strpos($_SERVER['PHP_SELF'],'aboutus.php')!==FALSE?'active':''; ?>" href="aboutus.php">About Us</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link <?= strpos($_SERVER['PHP_SELF'],'service.php')!==FALSE?'active':''; ?>"  
                        href="service.php">Services</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link <?= strpos($_SERVER['PHP_SELF'],'gallery.php')!==FALSE?'active':''; ?>" 
                        href="gallery.php">Gallery</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link <?= strpos($_SERVER['PHP_SELF'],'contact.php')!==FALSE?'active':''; ?>" 
                        href="contact.php">Contact Us</a>
                  </li>
                  <li class="nav-item d-lg-none">
                     <a class="nav-link" href="login.php">Login</a>
                  </li>
                  <li class="nav-item d-lg-none">
                     <a class="nav-link" href="register.php">Register</a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
       <button class="navbar-toggler elegant-toggler" type="button" 
         data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
      <img src="./images/hamburger.png" alt="hamburger">
      </button>
   </div>
</nav>