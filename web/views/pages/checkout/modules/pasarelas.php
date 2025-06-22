<div class="card bg-white">
	
	<div class="p-4">

	
			
			
			<div class="form-check border px-2 clearfix mb-3">
			
				<input type="radio" class="form-check-input mt-2 ml-1" id="radio1" name="optradio" value="paypal" checked>

				<label for="radio1" class="form-check-label float-right">
					
					<span>
						Pagar con PayPal 
						<img src="/views/assets/img/template/paypal.jpg" class="img-fluid" style="width:200px">
					</span>

				</label>

			</div>



		<div class="form-check border px-2 clearfix mb-3">
		
			<input type="radio" class="form-check-input mt-2 ml-1" id="radio2" name="optradio" value="dlocal">

			<label for="radio2" class="form-check-label float-right">
				
				<span>
					Pagar con D-Local Go
					<img src="/views/assets/img/template/d-local-go.jpg" class="img-fluid" style="width:200px">
				</span>

			</label>

		</div>

		<?php if (TemplateController::exchange("country") == "Colombia"): ?>
		
			
			<div class="form-check border px-2 clearfix mb-3">
			
				<input type="radio" class="form-check-input mt-2 ml-1" id="radio3" name="optradio" value="mercado_pago">

				<label for="radio3" class="form-check-label float-right">
					
					<span>
						Pagar con Mercado Pago 
						<img src="/views/assets/img/template/mercado_pago.jpg" class="img-fluid" style="width:200px">
					</span>

				</label>

			</div>

		<?php endif ?>


		<button type="submit" class="btn btn-default btn-block templateColor border-0 rounded py-2">Proceder al pago</button>

		<?php 

            require_once "controllers/payments.controller.php";
            $payment = new PaymentsController();
            $payment -> payment();

        ?>

	</div>

</div>