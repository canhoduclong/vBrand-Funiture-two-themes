<?php 
/**
 * Template Name: Dịch vụ Page
 */
get_header();
?>
   
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