<?php 
defined( 'ABSPATH' ) || exit;
global $product;
// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<!-- Start Column 2 -->
<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
    <a class="product-item" href="<?=esc_url(get_permalink())?>">
        <?php the_post_thumbnail('single-post-thumbnail', array('class' => 'img-fluid product-thumbnail')); ?>
        
        <h3 class="product-title"><?=the_title()?></h3>
        <strong class="product-price"><?=wc_price(get_post_meta(get_the_ID(), '_price', true))?></strong>

        <span class="icon-cross">
            <img src="<?=get_template_directory_uri()?>/images/cross.svg" class="img-fluid">
        </span>
    </a>
</div> 
<!-- End Column 2 --> 