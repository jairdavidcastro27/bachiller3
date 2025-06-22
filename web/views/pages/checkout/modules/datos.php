<div class="card bg-white p-4">

	<!--==========================================
  	Nombre
  	===========================================-->

  	<div class="mt-3">
		 		 			
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

	<!--==========================================
  	Email
  	===========================================-->

  	<div class="mt-3">

		<label for="email" class="form-label">Email:</label>

		<input 
		type="email" 
		class="form-control" 
		id="email" 
		value="<?php echo $_SESSION["user"]->email_user ?>" 
		readonly>

	</div>

	<!--==========================================
  	País
  	===========================================-->

  	<div class="mt-3">

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

	<!--==========================================
  	Estado
  	===========================================-->

  	<div class="mt-3">
		
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

	<!--==========================================
  	Ciudad
  	===========================================-->

	<div class="mt-3">
		
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

	<!--==========================================
  	Teléfono
  	===========================================-->

	<div class="mt-3">
		
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

	<!--==========================================
  	Dirección
  	===========================================-->

  	<div class="mt-3">

		<label for="address" class="form-label">Dirección:</label>

		<textarea 
		class="form-control p-2"
		id="address"
		rows="5" 
		onchange="validateJS(event,'complete')"
		name="address_user"><?php echo $_SESSION["user"]->address_user ?></textarea>

	</div>


</div>