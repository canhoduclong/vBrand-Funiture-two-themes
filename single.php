<?php
	get_header();
?> 
 
<div class="product-section" id="product">
    <div class="container">
        <div class="row">  
            <div class="col-lg-8">
                <div class="post-content">
                    <h2 class="stitle">
                        <?php the_title(); ?>
                    </h2>
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post();?>
                            <?php the_post_thumbnail('full'); ?>
                            <?php the_content(); ?> 
                        <?php endwhile;  ?>
                    <?php else: ?>
                        <p>!Sorry no posts here</p>
                    <?php endif; ?>
                </div>
                <div class="post-related">
                    <!-- Hiển thị bài viết theo Tag -->
                    <div id="relatedposttags">    
                        <?php
                            $tags = wp_get_post_tags(get_the_ID());
                            if ($tags) 
                            {
                                $tag_ids = array();
                                foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
                                // lấy danh sách các tag liên quan
                                $args=array(
                                'tag__in' => $tag_ids,
                                'post__not_in' => array(get_the_ID()), // Loại trừ bài viết hiện tại
                                'showposts'=>5, // Số bài viết bạn muốn hiển thị.
                                'caller_get_posts'=>1
                                );
                                $my_query = new wp_query($args);
                                if( $my_query->have_posts() ) 
                                {
                                    echo '<h3>Bài viết liên quan</h3><ul>';
                                    while ($my_query->have_posts()) 
                                    {
                                        $my_query->the_post();
                                        ?>
                                        <li><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                                        <?php
                                    }
                                    echo '</ul>';
                                }
                            }
                        ?>
                    </div>
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