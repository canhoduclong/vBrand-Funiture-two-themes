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