<?php
/**
 * Template Name: Sản phẩm define
 */
get_header();
$themeData = vbrand_load_theme_data();

?>
 
  

			<div class="intro-slider-container mb-4">
                <div class="intro-slider owl-carousel owl-simple owl-nav-inside" data-toggle="owl" data-owl-options='{
                        "nav": false, 
                        "dots": true,
                        "responsive": {
                            "992": {
                                "nav": true,
                                "dots": false
                            }
                        }
                    }'>
					
					<div class="intro-slide" style="background-image: url(<?php echo $themeData->get('banner_image'); ?>">
                        <div class="container intro-content">
                            <h3 class="intro-subtitle text-primary"><?php echo $themeData->get('banner_title');?></h3>
                            <h1 class="intro-title"><?php echo $themeData->get('banner_intro_title');?></h1>

                            <a href="<?php echo $themeData->get('banner_main_button_link'); ?>" class="btn btn-outline-primary-2">
                                <span><?php echo $themeData->get('banner_more');?></span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .intro-content -->
                    </div><!-- End .intro-slide -->

					 
                    

                </div><!-- End .intro-slider owl-carousel owl-simple -->



				

                <span class="slider-loader"></span><!-- End .slider-loader -->
            </div><!-- End .intro-slider-container -->


			<div class="container"> 
				<div class="products mb-3">
                    <div class="row">

					<?php if ($themeData->get('products_module_show')) { ?>
					<?php
						$count = $themeData->get('products_module_number');					
						$case = $themeData->get('products_module_type');
					?>
					<?php
						switch ($case) {
							case "hot":
								$args = array(
									'post_type'      => 'product',
									'posts_per_page' => $count,
									'meta_query'     => array(
										'relation' => 'OR',
										array(
											'key'   => 'hot_product', // Change this to your hot product custom field
											'value' => '1',           // Assuming '1' means it's marked as hot
										)
									),
								); 
								break;                        
							case "feature":
								$args = array(
									'post_type'      => 'product',
									'posts_per_page' => $count,
									'meta_query'     => array(
										'relation' => 'OR' ,
										array(
											'key'   => '_featured',   // WooCommerce uses '_featured' for featured products
											'value' => 'yes',
										),
									),
								);
								break;
							case "new":
								$args = array(
									'post_type'      => 'product',
									'posts_per_page' => $count,
									'meta_query'     => array(
										'relation' => 'OR',
										array(
											'key'   => 'new_product', // Change this to your new product custom field
											'value' => '1',           // Assuming '1' means it's marked as new
										), 
									),
								);
							default:
								$args = array(
									'post_type'      => 'product',
									'posts_per_page' => $count,
								);
						} 
						
						$products = new WP_Query($args);


						
	if ( woocommerce_product_loop() ) {	
		
		/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		do_action( 'woocommerce_before_shop_loop' );

		woocommerce_product_loop_start();



						if ($products->have_posts()){ 
							$i=1;
							while ($products->have_posts()){
								$products->the_post(); 

                                /**
                                 * Hook: woocommerce_shop_loop.
                                 */
                                do_action( 'woocommerce_shop_loop' ); 

                                wc_get_template_part( 'content', 'product' );
								 
								$i++;
							}
						}
						wp_reset_postdata(); // Đặt lại truy vấn sản phẩm
					
		
			woocommerce_product_loop_end();

			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );

					}

					?> 

					<?php }?>
                    
                    </div>
				</div>					
			</div>
 
			   

<?php
	get_footer();
?>