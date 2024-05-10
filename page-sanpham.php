<?php 
/**
 * Template Name: Sản phẩm define
 */
get_header();
?> 
 
 
<!-- Start Product Section -->
<div class="product-section">
	<div class="container">
		<div class="row">
 
            <?php
                /**
                 * Hiển thị bài viết mới nhất
                 */

                $number_of_posts = 8;

                // Truy vấn các bài viết mới nhất
                $args = array(
                    'post_type' => 'product', // Loại bài viết
                    'posts_per_page' => $number_of_posts, // Số lượng bài viết muốn hiển thị
                    'orderby' => 'date', // Sắp xếp theo ngày đăng
                    'order' => 'DESC', // Thứ tự giảm dần (mới nhất trước)
                );

				$args = array(
					'post_type' => 'product',
					'posts_per_page' => -1, // -1; Hiển thị tất cả sản phẩm trong danh mục        	 
				);
				$products = new WP_Query($args);
				if ($products->have_posts()){ 
					while ($products->have_posts()){
						$products->the_post();
						wc_get_template_part('content', 'product'); 
					}
				}
				wp_reset_postdata(); // Đặt lại truy vấn sản phẩm
			?>

		</div>
	</div>
</div>
 

 

<?php
get_footer('home');

?>