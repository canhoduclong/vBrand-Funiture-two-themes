<?php 
/**
 * Template Name: Shop page define
 */
get_header();
?>
<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">

<?php
// load plugin
$response = vbrandsync_getResponse('/'); 
?>
<img src="<?php
echo \App\Models\Setting::getThemeOptions()->site_logo;

?>" />
<p class="mb-4">
	<?php echo \App\Models\Setting::getThemeOptions()->woo_description; ?>
</p>



					<p><a href="" class="btn btn-secondary me-2">Liên hệ</a><a href="#" class="btn btn-white-outline">Khám phá ngay</a></p>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="hero-img-wrap">
					<img src="<?=get_template_directory_uri()?>/images/couch.png" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Hero Section -->


 
<!-- Start Product Section -->
<div class="product-section">
	<div class="container">
		<div class="row">

			<!-- Start Column 1 -->
			<div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
				<h2 class="mb-4 section-title">SẢN PHẨM MỚI</h2>
				<p class="mb-4">
					Những mâu sản phẩm luôn đem lại cho bạn những cảm hứng tuyệt vời, sáng tạo trong cuộc sống.
				 </p>
				 <p class="mb-4">
					Rất nhiều mẫu ghế nội thất phù hợp với bạn đang sẵn sàng chơ bạn ghé coi	
				</p>
				<p class="mb-4">
					Hân hạnh trào đón bạn
				</P>
				<p>
					<a href="shop.html" class="btn btn-primary">Khám phá thêm</a>
				</p>
			</div> 
			<!-- End Column 1 -->

			<?php
				$args = array(
					'post_type' => 'product',
					'posts_per_page' => 3 , // -1; Hiển thị tất cả sản phẩm trong danh mục        	 
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



 



<!-- Start Why Choose Us Section -->
<div class="why-choose-section">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-6">
				<h2 class="section-title">Tại sao Chọn Chúng Tôi</h2>
				<p>
				chúng tôi mang lại sự kết hợp hoàn hảo giữa thiết kế độc đáo và chất lượng xuất sắc. Chúng tôi tôn trọng nguyên liệu tự nhiên và sử dụng chúng để tạo ra những sản phẩm nội thất đẹp mắt và bền bỉ.
				</p>
				<div class="row my-5">
					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="<?=get_template_directory_uri()?>/images/truck.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Nhanh &amp; Vận chuyển Free</h3>
							<p>Vận chuyển nhanh chóng, không phát sinh chi phí vì dịch vụ hoàn toàn miễn phí</p>
						</div>
					</div>

					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="<?=get_template_directory_uri()?>/images/bag.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Dễ dàng di chuyển, tháo lắp</h3>
							<p>Sản phẩm dễ dàng di chuyển và tháo lắp tới vị trí bạn cần đặt.</p>
						</div>
					</div>

					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="<?=get_template_directory_uri()?>/images/support.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>24/7 Hỗ trợ</h3>
							<p> Chúng tôi Luôn luôn ở đây, 24/7. Hãy tin tưởng chúng tôi khi bạn cần gấp. </p>
						</div>
					</div>

					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="<?=get_template_directory_uri()?>/images/return.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Thiết kế sáng tạo, hiện địa</h3>
							<p>Với nhiều thiết kế đẹp, sáng tạo, luôn mang đến cho bạn sức sống mới.</p>
						</div>
					</div>

				</div>
			</div>

			<div class="col-lg-5">
				<div class="img-wrap">
					<img src="<?=get_template_directory_uri()?>/images/why-choose-us-img.jpg" alt="Image" class="img-fluid">
				</div>
			</div>

		</div>
	</div>
</div>
<!-- End Why Choose Us Section -->

<!-- Start We Help Section -->
<div class="we-help-section">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-7 mb-5 mb-lg-0">
				<div class="imgs-grid">
					<div class="grid grid-1"><img src="<?=get_template_directory_uri()?>/images/img-grid-1.jpg" alt="Untree.co"></div>
					<div class="grid grid-2"><img src="<?=get_template_directory_uri()?>/images/img-grid-2.jpg" alt="Untree.co"></div>
					<div class="grid grid-3"><img src="<?=get_template_directory_uri()?>/images/img-grid-3.jpg" alt="Untree.co"></div>
				</div>
			</div>
			<div class="col-lg-5 ps-lg-5">
				<h2 class="section-title mb-4">KIẾN TẠO NHỮNG KHÔNG GIAN SÁNG TẠO TRÀN ĐẦY SỨC SỐNG</h2>
				<p>
				Với đội ngũ thiết kế chuyên nghiệp và giàu kinh nghiệm, cam kết tạo ra những không gian sáng tạo, độc đáo và tràn đầy sức sống. Bằng sự tận tâm và tài năng, chúng tôi luôn sẵn sàng biến những ý tưởng thành hiện thực, đem lại cho bạn những trải nghiệm không gì sánh bằng trong việc thiết kế và tạo dựng không gian sống hoàn hảo
				</p>

				<ul class="list-unstyled custom-list my-4">
					<li>Thiết kế hoàn hảo</li>
					<li>Màu sắc trẻ trung</li>
					<li>Đa dạng mẫu mã</li>
					<li>Chất liệu tự nhiên</li>
				</ul>
				<p><a herf="#" class="btn">Khám phá ngay</a></p>
			</div>
		</div>
	</div>
</div>
<!-- End We Help Section -->

<!-- Start Popular Product -->
<div class="popular-product">
	<div class="container">
		<div class="row">

			<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
				<div class="product-item-sm d-flex">
					<div class="thumbnail">
						<img src="<?=get_template_directory_uri()?>/images/product-1.png" alt="Image" class="img-fluid">
					</div>
					<div class="pt-3">
						<h3>Ghế nội thất</h3>
						<p>
							Thời trang, phong cách thời thượng kết hợp với gam màu đày quyến rũ	cho không gian của bạn
						</p>
						<p><a href="#">Xem thêm</a></p>
					</div>
				</div>
			</div>

			<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
				<div class="product-item-sm d-flex">
					<div class="thumbnail">
						<img src="<?=get_template_directory_uri()?>/images/product-2.png" alt="Image" class="img-fluid">
					</div>
					<div class="pt-3">
						<h3>Bàn làm việc</h3>
						<p>
							Không gian làm việc sáng tạo, tràn đầy sức sống giúp bạn tiếp tục có thêm nhũng ý tưởng mới cho công việc hàng ngày
						</p>
						<p><a href="#">xem thêm</a></p>
					</div>
				</div>
			</div>

			<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
				<div class="product-item-sm d-flex">
					<div class="thumbnail">
						<img src="<?=get_template_directory_uri()?>/images/product-3.png" alt="Image" class="img-fluid">
					</div>
					<div class="pt-3">
						<h3>Bàn học cho bé</h3>
						<p>
							Mẫu bàn với thiết kế sáng tạo giúp bế có thêm không gian sáng tạo cho mỗi ngày học tập
						</p>
						<p><a href="#">xem thêm</a></p>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- End Popular Product -->

<!-- Start Popular Product -->
<div class="popular-product">
	<div class="container">
		<div class="row">

			<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
				<div class="product-item-sm d-flex">
					<div class="thumbnail">
						<img src="<?=get_template_directory_uri()?>/images/product-1.png" alt="Image" class="img-fluid">
					</div>
					<div class="pt-3">
						<h3>Ghế nội thất</h3>
						<p>
							Thời trang, phong cách thời thượng kết hợp với gam màu đày quyến rũ	cho không gian của bạn
						</p>
						<p><a href="#">Xem thêm</a></p>
					</div>
				</div>
			</div>

			<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
				<div class="product-item-sm d-flex">
					<div class="thumbnail">
						<img src="<?=get_template_directory_uri()?>/images/product-2.png" alt="Image" class="img-fluid">
					</div>
					<div class="pt-3">
						<h3>Bàn làm việc</h3>
						<p>
							Không gian làm việc sáng tạo, tràn đầy sức sống giúp bạn tiếp tục có thêm nhũng ý tưởng mới cho công việc hàng ngày
						</p>
						<p><a href="#">xem thêm</a></p>
					</div>
				</div>
			</div>

			<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
				<div class="product-item-sm d-flex">
					<div class="thumbnail">
						<img src="<?=get_template_directory_uri()?>/images/product-3.png" alt="Image" class="img-fluid">
					</div>
					<div class="pt-3">
						<h3>Bàn học cho bé</h3>
						<p>
							Mẫu bàn với thiết kế sáng tạo giúp bế có thêm không gian sáng tạo cho mỗi ngày học tập
						</p>
						<p><a href="#">xem thêm</a></p>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- End Popular Product -->

<?php

/**
 * Hiển thị bài viết mới nhất
 */

$number_of_posts = 8;

// Truy vấn các bài viết mới nhất
$args = array(
    'post_type' => 'post', // Loại bài viết
    'posts_per_page' => $number_of_posts, // Số lượng bài viết muốn hiển thị
    'orderby' => 'date', // Sắp xếp theo ngày đăng
    'order' => 'DESC', // Thứ tự giảm dần (mới nhất trước)
);

$query = new WP_Query($args);

// Kiểm tra xem có bài viết nào không
if ($query->have_posts()) : ?>
<!-- Start Blog Section -->
<div class="blog-section">
	<div class="container">
		<div class="row mb-5">
			<div class="col-md-6">
				<h2 class="section-title">TIN MỚI</h2>
			</div>
			<div class="col-md-6 text-start text-md-end">
				<a href="<?=home_url('/')?>tin-tuc" class="more">Xem thêm</a>
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

<?php
get_footer('home');

?>