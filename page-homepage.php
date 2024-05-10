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
					
					<div class="intro-slide" style="background-image: url(<?=get_template_directory_uri()?>/assets/images/demos/demo-11/slider/slide-1.jpg);">
                        <div class="container intro-content">
                            <h3 class="intro-subtitle text-primary"><?php echo $themeData->get('banner_title');?></h3>
                            <h1 class="intro-title"><?php echo $themeData->get('banner_intro_title');?></h1>

                            <a href="<?php echo $themeData->get('banner_main_button_link'); ?>" class="btn btn-outline-primary-2">
                                <span><?php echo $themeData->get('banner_more');?></span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .intro-content -->
                    </div><!-- End .intro-slide -->

					<div class="intro-slide" style="background-image: url(<?=get_template_directory_uri()?>/assets/images/demos/demo-11/slider/slide-2.jpg);">
                        <div class="container intro-content">
                            <h3 class="intro-subtitle text-primary">all at 50% off</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title text-white">The Most Beautiful <br>Novelties In Our Shop</h1><!-- End .intro-title -->

                            <a href="category.html" class="btn btn-outline-primary-2 min-width-sm">
                                <span>SHOP NOW</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .intro-content -->
                    </div><!-- End .intro-slide -->

                    

                </div><!-- End .intro-slider owl-carousel owl-simple -->



				

                <span class="slider-loader"></span><!-- End .slider-loader -->
            </div><!-- End .intro-slider-container -->


			<div class="container">
				<div class="toolbox toolbox-filter">
                    <div class="toolbox-left">
                        <a href="#" class="filter-toggler">Filters</a>

                    </div><!-- End .toolbox-left -->
                    <div class="toolbox-right">
                        <ul class="nav-filter product-filter">
                            <li class="active"><a href="#" data-filter="*">All</a></li>
                            <li><a href="#" data-filter=".furniture">Furniture</a></li>
                            <li><a href="#" data-filter=".lighting">Lighting</a></li>
                            <li><a href="#" data-filter=".accessories">Accessories</a></li>
                            <li><a href="#" data-filter=".sale">Sale</a></li>
                        </ul>
                    </div><!-- End .toolbox-right -->
                </div><!-- End .filter-toolbox -->

				<div class="widget-filter-area" id="product-filter-area">
                    <a href="#" class="widget-filter-clear">Clean All</a>

                    <div class="filter-area-wrapper">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="widget">
                                    <h3 class="widget-title">
                                        Category:
                                    </h3><!-- End .widget-title -->

                                    <div class="filter-items filter-items-count">
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cat-1">
                                                <label class="custom-control-label" for="cat-1">All</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">24</span>
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cat-2">
                                                <label class="custom-control-label" for="cat-2">Furniture</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">3</span>
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cat-3">
                                                <label class="custom-control-label" for="cat-3">Lighting</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">2</span>
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cat-4">
                                                <label class="custom-control-label" for="cat-4">Accessories</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">4</span>
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cat-5">
                                                <label class="custom-control-label" for="cat-5">Sale</label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">2</span>
                                        </div><!-- End .filter-item -->
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget -->
                            </div><!-- End .col-sm-6 col-lg-3 -->

                            <div class="col-sm-6 col-lg-3">
                                <div class="widget">
                                    <h3 class="widget-title">
                                        Sort by:
                                    </h3><!-- End .widget-title -->

                                    <div class="filter-items">
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="radio" class="custom-control-input" checked id="sort-1" name="sortby">
                                                <label class="custom-control-label" for="sort-1">Default</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="radio" class="custom-control-input" id="sort-2" name="sortby">
                                                <label class="custom-control-label" for="sort-2">Popularity</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="radio" class="custom-control-input" id="sort-3" name="sortby">
                                                <label class="custom-control-label" for="sort-3">Average Rating</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="radio" class="custom-control-input" id="sort-4" name="sortby">
                                                <label class="custom-control-label" for="sort-4">Newness</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="radio" class="custom-control-input" id="sort-5" name="sortby">
                                                <label class="custom-control-label" for="sort-5">Price: Low to High</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="radio" class="custom-control-input" id="sort-6" name="sortby">
                                                <label class="custom-control-label" for="sort-6">Price: High to Low</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget -->
                            </div><!-- End .col-sm-6 col-lg-3 -->

                            <div class="col-sm-6 col-lg-3">
                                <div class="widget">
                                    <h3 class="widget-title">
                                        Colour:
                                    </h3><!-- End .widget-title -->

                                    <div class="filter-colors filter-colors-vertical">
                                        <a href="#" style="background: #b87145;"><span>Brown</span></a>
                                        <a href="#" style="background: #f0c04a;"><span>Yellow</span></a>
                                        <a href="#" style="background: #333333;"><span>Black</span></a>
                                        <a href="#" class="selected" style="background: #cc3333;"><span>Red</span></a>
                                        <a href="#" style="background: #ebebeb;"><span>White</span></a>
                                    </div><!-- End .filter-colors -->
                                </div><!-- End .widget -->
                            </div><!-- End .col-sm-6 col-lg-3 -->

                            <div class="col-sm-6 col-lg-3">
                                <div class="widget">
                                    <h3 class="widget-title">
                                        Price:
                                    </h3><!-- End .widget-title -->

                                    <div class="filter-price">
                                        <div class="filter-price-text">
                                            Price Range:
                                            <span id="filter-price-range"></span>
                                        </div><!-- End .filter-price-text -->

                                        <div id="price-slider"></div><!-- End #price-slider -->
                                    </div><!-- End .filter-price -->
                                </div><!-- End .widget -->
                            </div><!-- End .col-sm-6 col-lg-3 -->
                        </div><!-- End .row -->
                    </div><!-- End .filter-area-wrapper -->
                </div><!-- End #product-filter-area.widget-filter-area -->

				<div class="products-container" data-layout="fitRows">
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
						if ($products->have_posts()){ 
							$i=1;
							while ($products->have_posts()){
								$products->the_post();
								// Ensure visibility.
								if ( empty( $product ) || ! $product->is_visible() ) {
									return;
								}
								?>
								<div class="product-item furniture col-6 col-md-4 col-lg-3">
									<div class="product product-4">
										<figure class="product-media">
											<a href="<?=esc_url(get_permalink())?>">
												<?php if (wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' )) { ?>
													<?php the_post_thumbnail('single-post-thumbnail', array('class' => 'product-image')); ?>
												<?php } else { ?>
													<img src="<?=get_template_directory_uri()?>/assets/images/demos/demo-11/products/product-<?=$i?>.jpg" class="product-image">
												<?php } ?>
											</a>
											
											<div class="product-action-vertical">
												<a href="<?=esc_url(get_permalink())?>" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
											</div><!-- End .product-action -->

											<div class="product-action">
												<a href="<?=esc_url(get_permalink())?>" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a>
											</div><!-- End .product-action -->
										</figure><!-- End .product-media -->

										<div class="product-body">
											<h3 class="product-title"><a href="<?=esc_url(get_permalink())?>"><?=the_title()?></a></h3>

											<div class="product-action">
												<a href="<?=esc_url(get_permalink())?>" class="btn-product btn-cart"><span>add to cart</span><i class="icon-long-arrow-right"></i></a>
											</div><!-- End .product-action -->
										</div><!-- End .product-body -->
									</div><!-- End .product -->
								</div><!-- End .product-item --> 
							<?php	
								$i++;
							}
						}
						wp_reset_postdata(); // Đặt lại truy vấn sản phẩm
					?> 

					<?php }?>
				</div>					
			</div>
 
			   

<?php
	get_footer();
?>