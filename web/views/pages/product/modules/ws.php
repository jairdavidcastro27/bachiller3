
<style>
	.whatsapp {
		position:fixed;
		width:60px;
  		height:60px;
  		bottom:40px;
  		right:40px;
  		background-color:#25d366;
  		color:#FFF;
  		border-radius:50px;
  		text-align:center;
  		font-size:30px;
  		z-index:100;
	}

	.whatsapp:hover{
	  color:#FFF;
	}

	.whatsapp-icon {
	  margin-top:13px;
	}

</style>

<a 
href="" 
class="whatsapp questionProduct text-white" 
target="_blank"
 name="<?php echo $product->name_product ?>" 
 phone="<?php echo $phone ?>"> <i class="fab fa-whatsapp whatsapp-icon text-white"></i>
</a>