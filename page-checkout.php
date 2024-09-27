<?php
	get_header();
?> 
<div class="page-header text-center" style="background-image: url('<?=get_template_directory_uri()?>/assets/images/page-header-bg.jpg')">
    <div class="container">
        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="page-title"><?php the_title(); ?><span>Thông tin thanh toán của bạn</span></h1>
	    <?php endif; ?> 
    </div>
</div>
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/');?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo wc_get_page_permalink('shop');?>">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->
<div class="page-content">
    <div class="checkout">
        <div class="container">
            <div class="row">   
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
</div>
<?php
	get_footer();
?>