<?php 
/**
 * Template Name: Dịch vụ Page
 */
get_header();
?>
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo home_url('/');?>">Trang chủ</a></li> 
            <li class="breadcrumb-item active" aria-current="page">Dịch vụ</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->
  <!-- About Start -->
        
  <div class="container"> 
        <div class="about"> 
        <div class="row align-items-center">
            <div class="col-lg-12">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                        the_title();
                        the_content();
                        endwhile; else: ?>
                        <p>!Sorry no posts here</p>
                <?php endif; ?>
            </div> 
        </div>
    </div>
</div>
<!-- About End -->

<?php
get_footer();

?>