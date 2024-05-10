<?php
include_once('wp-load.php');
 
// Xử lý truy vấn sản phẩm dựa trên danh mục được chọn
if (isset($_POST['category_ids']) && is_array($_POST['category_ids'])) {
	
    $args = array(
        'post_type' => 'product',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $_POST['category_ids'],
                'operator' => 'IN',
            ),
        ),
    ); 

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            the_post();
			do_action( 'woocommerce_shop_loop' );
			wc_get_template_part( 'content', 'product' );
        }
        wp_reset_postdata();
    } else {
        echo 'Không có sản phẩm nào.';
    }
}

//echo json_encode($product_data);
