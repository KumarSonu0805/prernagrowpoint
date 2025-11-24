
    <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

          <p>
            We could not find the page you were looking for.
          </p>
          <?php
          if(!empty($_SERVER['HTTP_REFERER'])){
          ?>
          <a href="<?= $_SERVER['HTTP_REFERER'] ?>">Go Back</a> Or 
          <?php
          }
          ?>
          <a href="<?= base_url(); ?>">Return to Home</a>

        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->