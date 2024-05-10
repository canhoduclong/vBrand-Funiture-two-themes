<?php
/**
 * Template Name: vBrand emplate One About Us
 */
?> 
<?php
	get_header();
?>
<?php
    $themeData = vbrand_load_theme_data();
?>

<?php if ($themeData->get('about_us_show') == 'true') { ?>
	<!-- Start Why Choose Us Section -->
	<div class="why-choose-section" id="about-us">
		<div class="container"> 
			<div class="row justify-content-center">
				<div class="col-lg-12 mb-4 pb-4 text-center">
					<h2 class="section-title">
						<?php echo $themeData->get('aboutus_title');?>
					</h2> 
				</div>
			</div>
			<div class="row justify-content-between mt-4 pt-4"> 
				<div class="col-lg-6"> 
					 <?php echo $themeData->get('aboutus_content');?> 	 
				</div> 
				<div class="col-lg-5">
					<div class="img-wrap">
						<img src="<?php echo $themeData->get('aboutus_image');?>" alt="Image" class="img-fluid">
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- End Why Choose Us Section -->
<?php } ?>
   

<?php
	get_footer();
?>