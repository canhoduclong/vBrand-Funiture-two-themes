<?php 
defined( 'ABSPATH' ) || exit;
global $product;
// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div class="product product-7">
    <figure class="product-media">
        <span class="product-label label-new">New</span>
        <a href="<?=esc_url(get_permalink())?>">
            <?php the_post_thumbnail('single-post-thumbnail', array('class' => 'product-image')); ?>
        </a>

        <div class="product-action-vertical">
            <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
            <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
            <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
        </div><!-- End .product-action-vertical -->

        <div class="product-action">
            <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
        </div><!-- End .product-action -->
    </figure><!-- End .product-media -->

    <div class="product-body">
        <div class="product-cat">
            <a href="#">Women</a>
        </div><!-- End .product-cat -->
        <h3 class="product-title"><a href="<?=esc_url(get_permalink())?>"><?=the_title()?></a></h3><!-- End .product-title -->
        <div class="product-price">
            <?=wc_price(get_post_meta(get_the_ID(), '_price', true))?>
        </div><!-- End .product-price -->
        <div class="ratings-container">
            <div class="ratings">
                <div class="ratings-val" style="width: 20%;"></div><!-- End .ratings-val -->
            </div><!-- End .ratings -->
            <span class="ratings-text">( 2 Reviews )</span>
        </div><!-- End .rating-container -->

        <div class="product-nav product-nav-dots">
            <a href="#" class="active" style="background: #cc9966;"><span class="sr-only">Color name</span></a>
            <a href="#" style="background: #7fc5ed;"><span class="sr-only">Color name</span></a>
            <a href="#" style="background: #e8c97a;"><span class="sr-only">Color name</span></a>
        </div><!-- End .product-nav -->
    </div><!-- End .product-body -->
</div><!-- End .product -->