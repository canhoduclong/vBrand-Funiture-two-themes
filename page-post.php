<?php
/**
 * Template Name: nhap 
 */
?> 
<?php
	get_header();
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

 

<div class="container">
	<div class="row">
		<div class="col col-md-8">

			<?php
			// Xử lý truy vấn sản phẩm dựa trên danh mục được chọn
			if (isset($_POST['selected_categories']) && is_array($_POST['selected_categories'])) {
				 
				$args = array(
					'post_type' => 'product',
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'field' => 'term_id',
							'terms' => $_POST['selected_categories'],
							'operator' => 'IN',
						),
					),
				); 
				$query = new WP_Query($args);

				if ($query->have_posts()) {
					while ($query->have_posts()) {
						$query->the_post();
						// Hiển thị thông tin sản phẩm theo nhu cầu của bạn
						the_title();
					}
					wp_reset_postdata();
				} else {
					echo 'Không có sản phẩm nào.';
				}
			}
			?>
		</div>
		<div class="col col-md-4">
			
			<form id="product-filter-form" method="get"></form>

				<ul id="category-list">
					<?php
					$product_categories = get_terms(array(
						'taxonomy' => 'product_cat',
						'hide_empty' => false,
					));

					foreach ($product_categories as $category) {
						echo '<li><input type="checkbox" name="selected_categories" value="' . esc_attr($category->term_id) . '"> ' . esc_html($category->name) . '</li>';
					}
					?>
				</ul>
				<button class="btn btn-secondary">
					Lọc
				</button>
		</div>
	</div>
</div>

 
<script>
	var selectedCategories = [];
	/*
	// Xử lý sự kiện khi checkbox được click
	$('#category-list input[type="checkbox"]').on('click', function () { 
		$('#category-list input[type="checkbox"]:checked').each(function () {
			// Lấy giá trị (ID) của checkbox được chọn và thêm vào mảng
			selectedCategories.push($(this).val());
		}); 
		$.ajax({
		//jQuery.ajax({
			url: '<?php echo admin_url('admin-ajax.php');?>',
			type: 'POST',
			dataType: 'json',
			data : {
				action: "productbycat", //	Tên action
				category_ids : selectedCategories,  
			},  
			success: function(response) {
				console.log( response.data );
			},
			error: function(xhr, status, error) {
				console.log(error);
			}
		});
	});
	*/
 
</script>
<?php
	get_footer();
?>