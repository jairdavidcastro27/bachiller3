<?php 


$select = "*";
$url = "banners?linkTo=location_banner,status_banner&equalTo=HOME,1&select=".$select;
$method = "GET";
$fields = array();

$banner = CurlController::request($url, $method, $fields);

if($banner->status == 200){

	$banner = $banner->results[0];

}else{

	$banner = null;
	

}

?>

<?php if (!empty($banner) && $banner->end_banner > date("Y-m-d")): ?>

<div class="container-fluid banner p-0" style="position:relative; background: url('<?php echo $path ?>views/assets/img/banner/<?php echo $banner->id_banner ?>/<?php echo $banner->background_banner ?>');background-size:cover;background-position: center; background-repeat: no-repeat;">
	
	<div class="container-fluid" style="background-color: rgba(0,0,0,.5);">
		
		<div class="container text-right p-5">
			
			<?php if ($banner->text_banner != null): ?>
			<h1 class="text-uppercase" style="color:#fff; text-shadow: 2px 2px 5px #000"><?php echo $banner->text_banner ?></h1>
			<?php endif ?>

			<?php if ($banner->discount_banner != null): ?>
			<h2 style="color:#fff; text-shadow: 2px 2px 5px #000"><?php echo $banner->discount_banner ?>% off</h2>
			<?php endif ?>

			<?php if ($banner->end_banner != null): ?>
			<h3 style="color:#fff; text-shadow: 2px 2px 5px #000">Termina el <?php echo TemplateController::formatDate(1, $banner->end_banner)?></h3>
			<?php endif ?>

		</div>

	</div>

</div>

<script>
	
	$(".banner").css({'background-attachment':'fixed'})

</script>

<?php endif ?>