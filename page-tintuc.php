<?php 
/**
 * Template Name: Tin tuc Page
 */
get_header();
 

/**
 * Hiển thị bài viết mới nhất
 */
$number_of_posts = 28;

$currentPage = get_query_var('paged');
$args=array(   
    'post_type'      => 'post', 
    'post_status'    => 'publish',
    'orderby' => 'date', // Sắp xếp theo ngày đăng
    'order' => 'DESC', // Thứ tự giảm dần (mới nhất trước)
    'posts_per_page' => $number_of_posts,
    'paged' => $currentPage
);
 
$query = new WP_Query($args);

// Kiểm tra xem có bài viết nào không
if ($query->have_posts()) : ?>
    <!-- Start Blog Section -->
    <div class="blog-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12">
                    <h2 class="section-title text-center">TIN MỚI</h2>
                </div> 
            </div>
    
            <div class="row">
        <?php	
            // Bắt đầu vòng lặp để hiển thị bài viết
            while ($query->have_posts()):
                $query->the_post();
                // Hiển thị tiêu đề bài viết và liên kết đến bài viết
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium'); // 'thumbnail' là kích thước hình ảnh nhỏ
                ?> 
                <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                    <div class="post-entry">
                        <a href="<?=get_permalink()?>" class="post-thumbnail">
    
                            <?php if ($thumbnail_url): ?>
                                <img src="<?=esc_url($thumbnail_url)?>" alt="<?=get_the_title()?>" />
                            <?php else: ?> 
                                <img src="<?=get_template_directory_uri()?>images/no-photo.jpg" alt="<?=get_the_title()?>" />   
                            <?php endif ?>
    
                        </a>
                        <div class="post-content-entry">
                            <h3><?=get_the_title()?></h3> 
                            <div class="meta">
                                <span>by <a href="#"><?=the_author()?></a></span> <span>on <a href="#"><?=get_the_date()?></a></span>
                            </div>
                        </div>
                    </div>
                </div>
       
                  <?php endwhile ?> 
                   <?php  wp_reset_postdata();?>
    
            </div>
        </div>
    </div>
    <!-- End Blog Section --> 
<?php endif ?>
    
    <div class="clear10"></div> 

    <div id="paginatio">
        <?php 
            echo "<ul class='paging nobottommargin'>" . paginate_links(array(
                'total' => $query->max_num_pages,
                'prev_text' => __('<'),
                'next_text' => __('>')
            )) . "</ul>";
        ?> 
     </div> 

<?php 
    get_footer();
?>