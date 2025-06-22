<!--=====================================
MODAL CREAR CUENTA
======================================-->

<div class="modal" id="register">

  <div class="modal-dialog modal-md modal-dialog-centered">

    <div class="modal-content">

      <!-- Modal Header -->
      <div 
      class="modal-header templateColor text-uppercase"
      style="justify-content: center !important; position: relative;"
      >

        Registro
        <button type="button" 
        class="btn border-0 text-white" data-bs-dismiss="modal"
        style="position: absolute; right:0; top:10px"
        >
          <i class="fas fa-times"></i>
        </button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

        <div class="row row-cols-1 row-cols-sm-2">
        
          <!--=====================================
          REGISTRO FACEBOOK
          ======================================-->

          <div class="col-sm-6 col-xs-12 text-center p-0 rounded-0">
            
            <a href="<?php echo $path ?>facebook?urlRedirect=<?php echo TemplateController::urlRedirect() ?>">
              
              <p class="py-3 facebook mx-2">
                <i class="fab fa-facebook-f  mr-3"></i>
                Registro con Facebook
              </p>

            </a>

          </div>

          <!--=====================================
          REGISTRO CON GOOGLE
          ======================================-->

          <div class="col-sm-6 col-xs-12 text-center p-0 rounded-0">
            
             <a href="<?php echo $path ?>google?urlRedirect=<?php echo TemplateController::urlRedirect() ?>">
              
              <p class="py-3 google mx-2">
                <i class="fab fa-facebook-f mr-3"></i>
                Registro con Google
              </p>

            </a>

          </div>

        </div>

        <hr class="p-0 mb-3" style="margin:0; border:1px solid #999">

        <!--=====================================
        FORMULARIO DE REGISTRO DIRECTO
        ======================================-->

        <form method="post" class="needs-validation" novalidate>
          
          <div class="input-group pb-3">
            
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            
            <input 
            type="text" 
            class="form-control" 
            name="name_user"
            placeholder="Nombre Completo" 
            onchange="validateJS(event,'text')"
            required>
            
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <div class="input-group pb-3">
            
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            
            <input type="email" 
            class="form-control" 
            name="email_user"
            placeholder="Correo Eletrónico" 
            onchange="validateDataRepeat(event,'email')"
            required>
            
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <div class="input-group pb-3">

            <span class="input-group-text"><i class="fas fa-lock"></i></span>

            <input 
            type="password" 
            class="form-control" 
            name="password_user"
            placeholder="Contraseña" 
            onchange="validateJS(event,'password')"
            required>

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div> 

          </div>

          <div class="d-flex justify-content-center mb-3">
            <div class="icheck-primary">
              <input type="checkbox" required>
              <a href="#" target="_blank" class="text-primary">Acepto los términos y condiciones</a>  
              <div class="valid-feedback">Válido.</div>
              <div class="invalid-feedback">Campo inválido.</div> 
            </div>
          </div> 

          <button class="btn btn-block bg-default templateColor">Crear Cuenta</button>   

          <?php 
          
            require_once "controllers/users.controller.php";
            $register = new UsersController();
            $register -> register();

          ?>


        </form>


      </div>

      <!-- Modal footer -->
      <div class="modal-footer"  style="justify-content: center !important;">

        <div>¿Ya tienes una cuenta registrada?  
          <a href="#login" class="ml-1 btn btn-dark btn-sm text-white" data-bs-toggle="modal" style="color:white !important">Ingresar</a>
        </div>
        
      </div>

    </div>
  </div>
</div>

<!--=====================================
MODAL INGRESO AL SISTEMA
======================================-->

<div class="modal" id="login">

  <div class="modal-dialog modal-md modal-dialog-centered">

    <div class="modal-content">

      <!-- Modal Header -->
      <div 
      class="modal-header templateColor text-uppercase"
      style="justify-content: center !important; position: relative;"
      >

        Ingreso
        <button type="button" 
        class="btn border-0 text-white" data-bs-dismiss="modal"
        style="position: absolute; right:0; top:10px"
        >
          <i class="fas fa-times"></i>
        </button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

        <div class="row row-cols-1 row-cols-sm-2">
        
          <!--=====================================
          INGRESO FACEBOOK
          ======================================-->

          <div class="col-sm-6 col-xs-12 text-center p-0 rounded-0">
            
             <a href="<?php echo $path ?>facebook?urlRedirect=<?php echo TemplateController::urlRedirect() ?>">
              
              <p class="py-3 facebook mx-2">
                <i class="fab fa-facebook-f  mr-3"></i>
                Ingreso con Facebook
              </p>

            </a>

          </div>

          <!--=====================================
          INGRESO CON GOOGLE
          ======================================-->

          <div class="col-sm-6 col-xs-12 text-center p-0 rounded-0">
            
             <a href="<?php echo $path ?>google?urlRedirect=<?php echo TemplateController::urlRedirect() ?>">
              
              <p class="py-3 google mx-2">
                <i class="fab fa-facebook-f mr-3"></i>
                Ingreso con Google
              </p>

            </a>

          </div>

        </div>

        <hr class="p-0 mb-3" style="margin:0; border:1px solid #999">

        <!--=====================================
        FORMULARIO DE LOGIN
        ======================================-->

        <form method="post" class="needs-validation" novalidate>

          <div class="input-group pb-3">
            
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            
            <input type="email" 
            class="form-control" 
            name="login_email_user"
            placeholder="Correo Eletrónico" 
            onchange="validateJS(event,'email')"
            required>
            
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div>

          </div>

          <div class="input-group pb-3">

            <span class="input-group-text"><i class="fas fa-lock"></i></span>

            <input 
            type="password" 
            class="form-control" 
            name="login_password_user"
            placeholder="Contraseña" 
            onchange="validateJS(event,'password')"
            required>

            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Campo inválido.</div> 

          </div>

            <p class="mb-3 text-center">
              <a href="#resetPasswordUser" data-bs-toggle="modal">¿Olvidaste la Contraseña? Haz clic aquí</a>
            </p>


          <button class="btn btn-block bg-default templateColor">Ingresar</button> 

          <?php 

              require_once "controllers/users.controller.php";
              $login = new UsersController();
              $login -> login();

          ?>


        </form>


      </div>

      <!-- Modal footer -->
      <div class="modal-footer"  style="justify-content: center !important;">

        <div>¿No tienes una cuenta?  
          <a href="#register" class="ml-1 btn btn-dark btn-sm text-white" data-bs-toggle="modal" style="color:white !important">Crear Cuenta</a>
        </div>
        
      </div>

    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="resetPasswordUser">
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

          require_once "controllers/users.controller.php";
          $reset = new UsersController();
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

<script src="<?php echo $path ?>views/assets/js/forms/forms.js"></script>