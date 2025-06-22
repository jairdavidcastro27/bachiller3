<?php 

$select = "*";
$url = "slides?linkTo=status_slide&equalTo=1"; 
$method = "GET";
$fields = array();

$slides = CurlController::request($url, $method, $fields);

if($slides->status == 200){

	$slides = $slides->results;
	

}else{

	$slides = array();
}


?>

<?php if (!empty($slides)): ?>

<link rel="stylesheet" href="<?php echo $path ?>views/assets/css/slide/slide.css">

<div class="jd-slider">
	
	<div class="slide-inner">
		
		<ul class="slide-area">

			<?php foreach ($slides as $key => $value): ?>

			<li>
				
				<img src="<?php echo $path ?>views/assets/img/slide/<?php echo $value->id_slide ?>/<?php echo $value->background_slide ?>" class="img-fluid">

				<?php if ($value->direction_slide != null): ?>

					<div class="slideOpt <?php echo $value->direction_slide ?>">
						
						<img src="<?php echo $path ?>views/assets/img/slide/<?php echo $value->id_slide ?>/<?php echo $value->img_png_slide ?>" style="<?php echo $value->coord_img_slide ?>">

						<div class="slideText" style="<?php echo $value->coord_text_slide ?>">
							
							<h1 class="text-uppercase" style="color:<?php echo json_decode($value->text_slide)[0]->color ?>"><?php echo json_decode($value->text_slide)[0]->text ?></h1>

							<h2 class="text-uppercase" style="color:<?php echo json_decode($value->text_slide)[1]->color ?>"><?php echo json_decode($value->text_slide)[1]->text ?></h2>

							<h3 class="text-uppercase" style="color:<?php echo json_decode($value->text_slide)[2]->color ?>"><?php echo json_decode($value->text_slide)[2]->text ?></h3>

							<a href="<?php echo $value->link_slide ?>">
	                            
	                            <button class="my-lg-3 btn text-uppercase templateColor border-0">

	                             <?php echo $value->text_btn_slide ?>

	                            </button>

	                        </a>

						</div>

					</div>

				<?php endif ?>

			</li>
				
			<?php endforeach ?>

		</ul>

	</div>

	<a class="prev d-none d-lg-block" href="#">
		<i class="fas fa-angle-left text-white px-3 py-5 rounded-right" style="background: rgba(0,0,0,.5);"></i>
	</a>
	<a class="next d-none d-lg-block" href="#">
	    <i class="fas fa-angle-right text-white px-3 py-5 rounded-left" style="background: rgba(0,0,0,.5);"></i>
	</a>

	<div class="controller py-2">
		<div class="indicate-area"></div>
	</div>

</div>


<div class="d-flex justify-content-center">
    
    <a id="btnSlide" class="btn border-0 rounded-0 templateColor py-2" style="width:200px">
        
            <i class="fa fa-angle-up templateColor"></i>

    </a>

</div>

<script src="<?php echo $path ?>views/assets/js/slide/slide.js"></script>

<?php endif ?>
