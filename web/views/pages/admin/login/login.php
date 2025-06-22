<div class="login-page">

  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-dark">
      <div class="card-header text-center">
        <h3><b>Administradores</b></h3>
      </div>
      <div class="card-body">

        <form method="post" class="needs-validation" novalidate>
          
          <div class="input-group mb-3">

            <input 
            onchange="validateJS(event,'email')"
            type="email" 
            class="form-control" 
            placeholder="Email" 
            name="loginAdminEmail" 
            required>

            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <div class="input-group mb-3">

            <input type="password" class="form-control" placeholder="Password" name="loginAdminPass" required>
           
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" 
                id="remember"
                onchange="rememberEmail(event)"
                >
                <label for="remember">
                  Recordar
                </label>
              </div>
            </div>

            <div class="col-4">
              <button type="submit" class="btn btn-default templateColor btn-block">Ingresar</button>
            </div>

          <?php 

            require_once "controllers/admins.controller.php";
            $login = new AdminsController();
            $login -> login();

          ?>
              
          </div>
        </form>

        <p class="mb-1">
          <a href="#resetPassword" data-bs-toggle="modal">Recordar Contraseña</a>
        </p>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

</div>

<!-- The Modal -->
<div class="modal" id="resetPassword">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Recuperar la contraseña</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        
        <p class="login-box-msg">¿Olvidaste tu contraseña? Aquí puedes solicitar una nueva.</p>

        <form method="post">
          
           <div class="input-group mb-3">
             
            <input 
            onchange="validateJS(event,'email')"
            type="email" 
            class="form-control" 
            placeholder="Email" 
            name="resetPassword" 
            required>

            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <div class="row">
            <div class="col-12">
              
                <button type="submit" class="btn btn-default templateColor btn-block py-2">Recibir nueva contraseña</button>
            </div>

          </div>

          <?php

          require_once "controllers/admins.controller.php";
          $reset = new AdminsController();
          $reset -> resetPassword();

          ?>

        </form>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>