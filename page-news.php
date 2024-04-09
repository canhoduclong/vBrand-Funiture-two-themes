<?php 
/**
* Template Name: vBrand Template One News
*/?>

<?php include 'header.php'; ?>
         

<?php
    $themeData = vbrand_load_theme_data();
?>  


<?php if ($themeData->get('articles_module_show')) : ?>
	<?php

	/**
	 * Hiển thị bài viết mới nhất
	 */

	$number_of_posts = $themeData->get('articles_module_number');

	// Truy vấn các bài viết mới nhất
	$args = array(
		'post_type' => 'post', // Loại bài viết
		'posts_per_page' => $number_of_posts, // Số lượng bài viết muốn hiển thị
		'post_status' => 'publish',
		// 'orderby' => 'date', // Sắp xếp theo ngày đăng
		// 'order' => 'DESC', // Thứ tự giảm dần (mới nhất trước)
        'posts_per_page' => 10,      // Number of posts per page
        'paged'          => get_query_var('paged') ? get_query_var('paged') : 1, 
	);

	$sort = $themeData->get('articles_module_sort');
	
	if ($sort == 'newest') {
		$args['order'] = 'DESC';
		$args['orderby'] = 'post_date';
	} else if ($sort == 'oldest') {
		$args['order'] = 'ASC';
		$args['orderby'] = 'post_date';
	} else {
		$args['order'] = 'DESC';
		$args['orderby'] = 'post_date';
	}

	$query = new WP_Query($args);

	// Kiểm tra xem có bài viết nào không
	if ($query->have_posts()) : ?>
	<!-- Start Blog Section -->
	<div class="blog-section" id="news">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-6">
					<h2 class="section-title">TIN MỚI</h2>
				</div> 
			</div>

			<div class="row">
		<?php	
			// Bắt đầu vòng lặp để hiển thị bài viết
			while ($query->have_posts()):
				$query->the_post();

				$content = get_the_content();
				$content = strip_tags($content);
				$shortDescription = substr($content, 0, 100);
				// Hiển thị tiêu đề bài viết và liên kết đến bài viết
				$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium'); // 'thumbnail' là kích thước hình ảnh nhỏ
				?> 
				<div class="col-lg-<?= 12/$number_of_posts ?>">
					<div class="post-entry">
						<a href="<?=get_permalink()?>" class="post-thumbnail">

							<?php if ($thumbnail_url): ?>
								<img width="100%" src="<?=esc_url($thumbnail_url)?>" alt="<?=get_the_title()?>" />
							<?php else: ?> 
								<img width="100%" class="border" src="<?=get_template_directory_uri()?>/images/placeholder.svg" alt="<?=get_the_title()?>" />   
							<?php endif ?>

						</a>
						<div class="post-content-entry">
							<h3><?=get_the_title()?></h3> 
							<p><?=$shortDescription?></p>
							<div class="meta">
								<span>by <a href="#"><?=the_author()?></a></span> <span>on <a href="#"><?=get_the_date()?></a></span>
							</div>
						</div>
					</div>
				</div>
	
				<?php endwhile ?> 

                <?php
                    // Pagination
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __('Previous', 'textdomain'),
                        'next_text' => __('Next', 'textdomain'),
                    ));
                ?>
				<?php  wp_reset_postdata();?>

			</div>
		</div>
	</div>
	<!-- End Blog Section --> 
<?php endif ?>
 
<?php endif ?> 
   

<?php
	get_footer();
?>