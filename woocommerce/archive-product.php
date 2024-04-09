<?php 
get_header();
?>
<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">
					<h1>Modern Interior <span clsas="d-block">Design Studio</span></h1>
					<p class="mb-4">Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique.</p>
					<p><a href="" class="btn btn-secondary me-2">Shop Now</a><a href="#" class="btn btn-white-outline">Explore</a></p>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="hero-img-wrap">
					<img src="<?=get_template_directory_uri()?>/images/couch.png" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Hero Section -->




<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <?php
        do_action( 'woocommerce_before_main_content' );
        do_action( 'woocommerce_archive_description' );
        ?> 
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
<?php

if ( woocommerce_product_loop() ) {
    //woocommerce_product_loop_start();
    if ( wc_get_loop_prop( 'total' ) ) {
   	 while ( have_posts() ) {
   		 the_post();
   		// do_action( 'woocommerce_shop_loop' );

   		 wc_get_template_part( 'content', 'product' );
   	 }
    }
    //woocommerce_product_loop_end();

   // do_action( 'woocommerce_after_shop_loop' );
}else {
    do_action( 'woocommerce_no_products_found' );
}
?>
 </div>

<?php
do_action( 'woocommerce_after_main_content' );
?>

       
    </div>
</section>

<?php
get_footer();
?>