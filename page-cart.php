<?php
	get_header();
?> 
<div class="page-header text-center" style="background-image: url('<?=get_template_directory_uri()?>/assets/images/page-header-bg.jpg')">
    <div class="container">
        <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->

<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/');?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo wc_get_page_permalink('shop');?>">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="cart"> 
    
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
<?php
	get_footer();
?>