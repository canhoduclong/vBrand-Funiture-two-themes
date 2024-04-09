<?php
	get_header();
?> 
<div class="product-section" id="product">
    <div class="container">
        <div class="row">  
            <div class="col-lg-12">
                <h2 class="section-title">
                    <?php the_title(); ?>
                </h2>
                <p> 
                <?php
                    if (class_exists('WooCommerce')) {  
 
                        $values = array(
                            'all' => __('All Products'),
                            '0-50' => __('$0 - $50'),
                            '50-100' => __('$50 - $100'),
                            // ...
                        );
                        ?>
                        <div id="price_slider">
    <div class="price_slider_wrapper">
        <input type="text" id="min_price" name="min_price" value="">
        <div class="price_slider"></div>
        <input type="text" id="max_price" name="max_price" value="">
    </div>
</div>
                <?php
                    }
                ?>
                </p>
            </div> 
            <div class="col-lg-12">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post();?>
                        <?php the_content(); ?>
                    <?php endwhile;  ?>
                <?php else: ?>
                    <p>!Sorry no posts here</p>
                <?php endif; ?>
            </div> 
        </div> 
    </div> 
</div>
<?php
	get_footer();
?>