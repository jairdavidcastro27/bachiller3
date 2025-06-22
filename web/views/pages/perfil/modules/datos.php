<div class="container py-3">
	
	<form method="post" class="needs-validation" novalidate>
		
		 <div class="row mb-3">
		 	
		 	<div class="col-12 col-lg-6 text-center text-lg-left">

	          	<h4 class="mt-3">Editar Datos</h4>

	      	</div>  

	      	<div class="col-12 col-lg-6 mt-2 d-none d-lg-block">
	      		
	      		  <button type="submit" class="btn border-0 templateColor float-right py-2 px-3 btn-sm rounded-pill">Guardar Información</button>

	      	</div>

	      	 <div class="col-12 text-center d-flex justify-content-center mt-2 d-block d-lg-none">
	      	 	
	      	 	<div> 
	      	 		<button type="submit" class="btn border-0 templateColor py-2 px-3 btn-sm rounded-pill">Guardar Información</button>
	      	 	</div>

	      	 </div>

		 </div>

		<?php 

		 require_once "controllers/users.controller.php";
		 $modify = new UsersController();
		 $modify->modify();

		?>



		 <div class="row row-cols-1 row-cols-md-2"> 

		 	<div class="col">
		 		
		 		 <div class="card">
		 		 	
		 		 	<div class="card-body">
		 		 		
		 		 		<div class="mb-3 mt-3">
		 		 			
		 		 			 <label for="text" class="form-label">Nombre:</label>

		 		 			 <input 
		 		 			 type="text"
		 		 			 class="form-control" 
		 		 			 id="text"
		 		 			 value="<?php echo $_SESSION["user"]->name_user ?>"
		 		 			 name="name_user"
		 		 			 onchange="validateJS(event,'text')"
		 		 			 required
		 		 			 >

		 		 			 <div class="valid-feedback">Válido.</div>
              				<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

		 		 		</div>

		 		 		<div class="mb-3 mt-3">

		 		 			<label for="email" class="form-label">Email:</label>

		 		 			<input 
		 		 			type="email" 
		 		 			class="form-control" 
		 		 			id="email" 
		 		 			value="<?php echo $_SESSION["user"]->email_user ?>" 
		 		 			readonly>

		 		 		</div>

		 		 		<?php if ($_SESSION["user"]->method_user == "directo"): ?>    

		 		 			<div class="mb-3">

		 		 				<label for="pwd" class="form-label">Password:</label>

		 		 				<input 
		 		 				type="password" 
		 		 				class="form-control" 
		 		 				id="pwd"
		 		 				placeholder="Modificar contraseña"
		 		 				onchange="validateJS(event,'password')"
		 		 				name="password_user">

		 		 				<div class="valid-feedback">Válido.</div>
		 		 				<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

		 		 			</div>

		 		 		<?php endif ?>

		 		 		<div class="mb-3 mt-3">

			              <label for="mehtod" class="form-label">Método de registro:</label>
			              
			              <input 
			              type="text" 
			              class="form-control" 
			              id="mehtod" 
			              value="<?php echo $_SESSION["user"]->method_user ?>" 
			              readonly>

			            </div>

		 		 	</div>


		 		 </div>

		 	</div>

		 	<div class="col">
		 		
		 		 <div class="card">
		 		 	
		 		 	<div class="card-body">
		 		 		
		 		 		<div class="mb-3 mt-3">

		 		 			<?php 

		 		 			$data = file_get_contents("views/assets/json/countries.json");
		 		 			$countries = json_decode($data, true);
		 		 			

		 		 			?>
		 		 			
		 		 			 <label for="country" class="form-label">País:</label>

		 		 			 <select 
		 		 			 id="country"
		 		 			 class="form-control select2"
		 		 			 name="country_user"
		 		 			  onchange="changeCountry(event)">

		 		 			  <?php if ($_SESSION["user"]->country_user != null): ?>

		 		 			  	<option value="<?php echo $_SESSION["user"]->country_user ?>_<?php echo explode("_", $_SESSION["user"]->phone_user)[0] ?>"><?php echo $_SESSION["user"]->country_user ?></option>
		 		 			  
		 		 			  <?php else: ?>

	 		 			  		<option value="">Seleccionar País</option>

		 		 			 	<?php foreach ($countries as $key => $value): ?>

		 		 			 		<option value="<?php echo $value["name"] ?>_<?php echo $value["dial_code"] ?>"><?php echo $value["name"] ?></option>
		 		 			 		
		 		 			 	<?php endforeach ?>
		 		 			  	
		 		 			  <?php endif ?>

		 		 			 </select>

		 		 			<div class="valid-feedback">Válido.</div>
              				<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

		 		 		</div>

		 		 		<div class="mb-3 mt-3">
		 		 			
		 		 			 <label for="department" class="form-label">Estado:</label>

		 		 			 <input 
		 		 			 type="text"
		 		 			 class="form-control" 
		 		 			 id="department"
		 		 			 value="<?php echo $_SESSION["user"]->department_user ?>"
		 		 			 name="department_user"
		 		 			 onchange="validateJS(event,'text')"
		 		 			 required
		 		 			 >

		 		 			 <div class="valid-feedback">Válido.</div>
              				<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

		 		 		</div>

		 		 		<div class="mb-3 mt-3">
		 		 			
		 		 			 <label for="city" class="form-label">Ciudad:</label>

		 		 			 <input 
		 		 			 type="text"
		 		 			 class="form-control" 
		 		 			 id="city"
		 		 			 value="<?php echo $_SESSION["user"]->city_user ?>"
		 		 			 name="city_user"
		 		 			 onchange="validateJS(event,'text')"
		 		 			 required
		 		 			 >

		 		 			 <div class="valid-feedback">Válido.</div>
              				<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

		 		 		</div>

		 		 		<div class="mb-3 mt-3">
		 		 			
		 		 			 <label for="phone" class="form-label">Número celular:</label>

		 		 			 <div class="input-group">

		 		 			 	<?php if ($_SESSION["user"]->phone_user != null): ?>

		 		 			 		<span class="input-group-text dialCode">+<?php echo explode("_", $_SESSION["user"]->phone_user)[0] ?></span>

		 		 			 	<?php else: ?>

		 		 			 		<span class="input-group-text dialCode">+00</span>
		 		 			 		
		 		 			 	<?php endif ?>

			 		 			<input 
			 		 			 type="text"
			 		 			 class="form-control" 
			 		 			 id="phone"
			 		 			 value="<?php if($_SESSION["user"]->phone_user != null){ echo explode("_", $_SESSION["user"]->phone_user)[1]; }?>"
			 		 			 name="phone_user"
			 		 			 required
			 		 			 data-inputmask="'mask': ['999-999-9999']"
			 		 			 data-mask
			 		 			 >

			 		 			<div class="valid-feedback">Válido.</div>
	              				<div class="invalid-feedback">Por favor llena este campo correctamente.</div>

              				</div>

		 		 		</div>
 	

		 		 	</div>


		 		 </div>

		 	</div>

		 </div>

		 <div class="row">

		 	<div class="col">

		 		<div class="card">

		 			<div class="card-body">

		 				<div class="mb-3 mt-3">

		 					<label for="address" class="form-label">Dirección:</label>

		 					<textarea 
		 					class="form-control p-2"
		 					id="address"
		 					rows="5" 
		 					onchange="validateJS(event,'complete')"
		 					name="address_user"><?php echo $_SESSION["user"]->address_user ?></textarea>

		 				</div>

		 			</div>

		 		</div>

		 	</div>

		 </div>

	</form>

</div>

<script src="<?php echo $path ?>views/assets/js/forms/forms.js"></script>