<?php
	get_header();
?> 

 
 
    <div class="breadcrumb">
        <div class="container">
            <div class="row">  
                <div class="col-lg-12">
                    <?php  
                        theme_breadcrumbs();
                    ?>
                </div>
            </div>
        </div>
    </div>
 

<div class="my-4" id="product">
    <div class="container">
        <div class="row">  
            <div class="col-lg-8">
                <h2 class="section-title mb-4">
                    <?php single_cat_title(); ?>
                </h2> 
                <div class="list-posts">
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post();?>
                            <div class="d-flex mb-3 py-2">
                                <div class="post-thumbs w-40 over-hidden">
                                    <a href="<?=get_permalink()?>">
                                        <?php the_post_thumbnail('thembnail'); ?>
                                    </a>
                                </div>
                                <div class="post-excerpt w-60 px-4">
                                    <h3 class="posts-title"><a href="<?=get_permalink()?>"><?php the_title(); ?></a></h3>
                                    <p><a href="<?=get_permalink()?>"><?php the_excerpt(); ?></a></p>
                                </div>
                            </div>  
                        <?php endwhile;  ?>
                    <?php else: ?>
                        <p>!Sorry no posts here</p>
                    <?php endif; ?>
                </div> 
            </div> 
            <div class="col-lg-4">
                <!-- Sidebar -->
                <aside id="secondary" class="widget-area mainsidebar">
                    <?php dynamic_sidebar('sidebar-1'); ?>
                    <div class="widget">
                        <h2 class="widget-title stitle">Chuyên mục</h2>
                        <ul class="categories">
                            <?php
                            $categories = get_categories();
                            foreach ($categories as $category) {
                                echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="widget mt-4">
                        <h2 class="widget-title stitle">Từ khóa</h2>
                        <div class="mt-4 tags"> 
                        
                            <?php
                            // Lấy danh sách 10 tags phổ biến nhất
                            $tags = get_terms(array(
                                'taxonomy' => 'post_tag',
                                'orderby' => 'count',
                                'order' => 'DESC',
                                'number' => 10,
                            ));

                            // Lặp qua từng tag và hiển thị
                            foreach ($tags as $tag) {
                                echo '<a href="' . get_tag_link($tag->term_id) . '" class="badge badge-dark">' . $tag->name . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                </aside>

 


            </div> 
        </div> 
    </div> 
</div>
<?php
	get_footer();
?>