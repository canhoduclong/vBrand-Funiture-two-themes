<?php
add_theme_support('woocommerce');
 /**
  * Định nghĩa menu cho themes
  */
function register_my_menu() {
    register_nav_menu('primary-menu', __('Primary Menu'));
}
add_action('after_setup_theme', 'register_my_menu');
 /**
 * design for widget for footer 
 */
function vbrand_widget_filter() {
	register_sidebar(array(
    	'name' => 'filter Widget Area',
    	'id' => 'filter-widget-area',
    	'description' => __( 'filter of product'),
    	'before_widget' => '<div class="widget">',
    	'after_widget' => '</div>',
    	'before_title' => '<h3 class="widget-title">',
    	'after_title' => '</h3>',
	));
}
add_action('widgets_init', 'vbrand_widget_filter');

/**
 * Use my custum plugin defind
 */
@include_once( ABSPATH.'/wp-content/plugins/shopmaker/shopmaker.php' ); 


/*
$demo_data_imported = get_option('demo_data_imported');
if ($demo_data_imported !== '1') {  
    require_once get_template_directory() . '/demo-data/import-demo-data.php'; 
    update_option('demo_data_imported', '1');
}

$vbrand_one_menu_setup = get_option('vbrand_one_menu_setup');

if (!$vbrand_one_menu_setup){
  
    $menu_exists = wp_get_nav_menu_object('Primary vBrand One Menu');  
   // echo "<pre>"; print_r($menu_exists);echo "</pre>";

    $menu_id = ''; 
    if (!$menu_exists) {
        // Nếu menu chưa tồn tại, hãy tạo nó
        $menu_id = wp_create_nav_menu('Primary vBrand One Menu');
    
        // Đăng ký menu với theme
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary-menu'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations); 
    }else {
        // Nếu menu đã tồn tại, lấy ID của nó
       
        $menu_id = $menu_exists->term_id;  
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary-menu'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);

       $update = get_theme_mod('nav_menu_locations');  echo "<pre>"; print_r($update); echo "</pre>";
       
    }
    update_option('vbrand_one_menu_setup', true);
    update_option('vbrand_shop_menu_setup', false); 
}

function add_additional_class_on_a($classes, $item, $args)
{
    if (isset($args->add_a_class)) {
        $classes['class'] = $args->add_a_class;
    }
    return $classes;
}

add_filter('nav_menu_link_attributes', 'add_additional_class_on_a', 1, 3);


 
function add_menu_link_class($atts, $item, $args) {
    // Kiểm tra xem menu đang sử dụng là 'primary-menu' và thêm class cho liên kết
    if ($args->theme_location == 'primary-menu') {
        $atts['class'] = 'nav-link';
    }
    return $atts;
}

add_filter('nav_menu_link_attributes', 'add_menu_link_class', 10, 3);


function link_shop_page(){ 
    if (class_exists('WooCommerce')) {
        // Get the shop page ID from the options table
        $shop_page_id = get_option('woocommerce_shop_page_id');

        // Check if the shop page ID is valid
        if ($shop_page_id) {
            // Get the permalink of the shop page
            $shop_page_link = get_permalink($shop_page_id);
            return esc_url($shop_page_link);
        }
    }
    return '';
}*/


/**
 * use hook of woocommerce
 */
add_action( 'filter_price', 'vbrand_filter_price' );
function vbrand_filter_price() {
// Your code
}


/**
 * Menu vBrand Synch
 */

function vbrand_shop_activate()
{
    $themeData = vbrand_load_theme_data();
    $menus = $themeData->get('menus'); 

    // tao pages tu menu
    foreach($menus as $menu){ 
        $page = vbrand_getOrCreatePageByTemplate($menu['type'], $menu['title']);  
        if($menu['type']=='shop'){
            update_option('woocommerce_shop_page_id', $page->ID);
        }     
    } 
    //--- set frontpage 
    vbrand_setfrontPageByTemplate('page-homepage.php');
}

// vbrand_shop_activate();

$vbrand_one_menu_setup = get_option('vbrand_one_menu_setup'); 
if (!$vbrand_one_menu_setup){
    vbrand_shop_activate();
    update_option('vbrand_one_menu_setup', true);
    update_option('vbrand_shop_menu_setup', false); 
}


//---- product fiter
add_filter ('woocommerce_variation_prices_price', 'custom_variation_price', 99, 3);
add_filter ('woocommerce_variation_prices_regular_price', 'custom_variation_price', 99, 3);

function custom_variation_price ($price, $variation, $product) {
    wc_delete_product_transients ($variation->get_id ());
    $product_id = $product->is_type ('variation') ? $product->get_parent_id () : $product->get_id ();
    if (has_term ('option 4', 'pa_choose_options', $product_id)) {
        return $price * 1.5;
    } else {
        return $price;
    }
}

/**
 * ajax function
 */

add_action( 'wp_ajax_productbycat', 'productbycat_init' );
add_action( 'wp_ajax_nopriv_productbycat', 'productbycat_init' );
function productbycat_init() { 
    $category_ids = (isset($_POST['category_ids']))?esc_attr($_POST['category_ids']) : '';
    if ($category_ids) {
		$result = '';
        $args = array(
            'post_type' => 'product',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $category_ids,
                    'operator' => 'IN',
                ),
            ),
        ); 
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                // Hiển thị thông tin sản phẩm theo nhu cầu của bạn
                $result .= get_the_title();
            }
            wp_reset_postdata();
        }
        echo $result;
        wp_send_json_success($result);
    }
    die();  //---- bắt buộc phải có khi kết thúc
}


/**
 * sidebar
 */
function theme_register_sidebars() {
    register_sidebar(array(
        'name' => __('Main Sidebar', 'theme-text-domain'),
        'id' => 'sidebar-1',
        'description' => __('Widgets in this area will be shown on all posts and pages.', 'theme-text-domain'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'theme_register_sidebars');

/**
 * Breadcrumb
 */ 

// Add the breadcrumbs to your theme by calling this function where you want them to appear 

function theme_register_sidebar() {
    register_sidebar(array(
        'name'          => __('Product Archive Sidebar', 'your-theme-textdomain'),
        'id'            => 'product-archive-sidebar',
        'description'   => __('Widgets in this area will be shown on the product archive page.', 'your-theme-textdomain'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'theme_register_sidebar');


 

/**
 * Show checkbox listing caegory
 */

// Hàm thay đổi câu lệnh query để lọc sản phẩm theo danh mục
function custom_shop_page_query($query) {
    if (is_shop() && $query->is_main_query()) {
        // Kiểm tra xem có thể lọc theo danh mục hay không
        if (isset($_GET['productcategories']) && !empty($_GET['productcategories'])) {
            $category_slugs = explode(',', $_GET['productcategories']);

            // Thêm điều kiện lọc theo danh mục vào câu lệnh query
            $tax_query = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $category_slugs,
                    'operator' => 'IN',
                ),
            );

            $query->set('tax_query', $tax_query);
        }
    }
}

// Hook để thực hiện thay đổi câu lệnh query trước khi thực hiện truy vấn
add_action('pre_get_posts', 'custom_shop_page_query');




function display_product_categories_checkbox() {
    // Get product categories
    $product_categories = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'orderby'    => 'count',
        'order'    => 'DESC',
    ));

    // Start the output buffer
    ob_start(); 

    $in_categories = [];

    if(isset($_GET['productcategories'])){
        $in_categories = explode( ',',  $_GET['productcategories'] );
    }
    // Display a checkbox for each category
    echo ' <div class="filter-items filter-items-count">';
    foreach ($product_categories as $category) {
        echo '<div class="filter-item">';
        echo    '<div class="custom-control custom-checkbox">'; 
        echo        '<input type="checkbox" class="custom-control-input"  name="product_categorie[]" value="' . esc_attr($category->slug) . '" id="' . esc_attr($category->slug) . '" >';

        echo        '<label class="custom-control-label" for="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</label>';
        echo    '</div>';
        echo    '<span class="item-count">'.$category->count.'</span>';
        echo    '</div>';
    }
    echo "</div>";

    // Return the buffered output
    return ob_get_clean();
}

// Shortcode for displaying product category filter
function product_category_filter_shortcode() {
    return display_product_categories_checkbox();
}

// Register the shortcode
add_shortcode('product_category_filter', 'product_category_filter_shortcode');

// Function to modify the product query based on selected categories
function filter_products_by_category($query) {
    if (isset($_GET['product_categories']) && is_array($_GET['product_categories'])) {
        $selected_categories = implode(',', $_GET['product_categories']); // Combine categories into a single variable

        $tax_query = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => explode(',', $selected_categories), // Split the combined categories back into an array
                'operator' => 'IN',
            ),
        );

        $query->set('tax_query', $tax_query);
    }
}

// Hook to filter products based on selected categories
add_action('woocommerce_product_query', 'filter_products_by_category');


/**
 * show short cart for menu
 */
function short_menu_cart_function(){
    return '<div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-cart-products">
                    <div class="product">
                        <div class="product-cart-details">
                            <h4 class="product-title">
                                <a href="product.html">Beige knitted elastic runner shoes</a>
                            </h4>

                            <span class="cart-product-info">
                                <span class="cart-product-qty">1</span>
                                x $84.00
                            </span>
                        </div><!-- End .product-cart-details -->

                        <figure class="product-image-container">
                            <a href="product.html" class="product-image">
                                <img src="assets/images/products/cart/product-1.jpg" alt="product">
                            </a>
                        </figure>
                        <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                    </div>

                    <div class="product">
                        <div class="product-cart-details">
                            <h4 class="product-title">
                                <a href="product.html">Blue utility pinafore denim dress</a>
                            </h4>

                            <span class="cart-product-info">
                                <span class="cart-product-qty">1</span>
                                x $76.00
                            </span>
                        </div>

                        <figure class="product-image-container">
                            <a href="product.html" class="product-image">
                                <img src="assets/images/products/cart/product-2.jpg" alt="product">
                            </a>
                        </figure>
                        <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                    </div>
                </div>

                <div class="dropdown-cart-total">
                    <span>Total</span> 
                    <span class="cart-total-price">$160.00</span>
                </div>

                <div class="dropdown-cart-action">
                    <a href="'.home_url('/').'/cart" class="btn btn-primary">View Cart</a>
                    <a href="'.home_url('/').'/checkout" class="btn btn-outline-primary-2">
                        <span>Checkout</span><i class="icon-long-arrow-right"></i>
                    </a>
                </div>
            </div>';
}
add_shortcode('short_menu_cart', 'short_menu_cart_function');

/**
 * Paging for products
 */
add_action( 'after_setup_theme', function() {
    add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 9 );
    add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
});




/**
 *  woocommerce
 */ 

  
 
function woocommerce_output_content_wrapper() { 
    //if(is_shop() || is_single()){ 
        echo ' <div class="col-lg-9">';
    //} 
} 

function before_shop_loop (){
    //if( is_shop() || is_product_category()){
        echo '<div class="products mb-3">';
    //}
}

function before_shop_loop_item (){
    //if( is_shop() || is_product_category()){
        echo '<div class="col-6 col-md-4 col-lg-4 col-xl-4">
                <div class="product product-7 text-center">
                    ';
    //}
}
function add_before_figure(){
    echo '<figure class="product-media">';
}
function add_after_figure(){
    echo '</figure>';
}

function after_shop_loop_item (){
    //if( is_shop() || is_product_category()){
        echo '</div>
            </div>';
    //}
}
function after_shop_loop (){
        echo '</div> ';
} 
function _output_content_wrapper_end (){
    //if( is_shop() || is_product_category()){
        echo '</div>';
    //}
}
 
 
function _item_title(){
    echo "<h1>hello</h1>";
}
function before_shop_toolbox(){
    echo '<div class="toolbox">';
}
function after_shop_toolbox(){
    echo '</div>';
}
function woocommerce_show_product_loop_sale_flash(){
    echo '<span class="product-label label-new">New</span>';
}
function product_action_vertical(){
    echo '<div class="product-action-vertical">
            <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>Thêm vào Yêu thích</span></a>
            <a href="popup/quickView.html" class="btn-product-icon btn-quickview btn-expandable" title="Quick view"><span>Xem nhanh</span></a>
            <a href="#" class="btn-product-icon btn-compare btn-expandable" title="So sánh"><span>So sánh</span></a>
        </div>';
}
function product_before_body_item(){
    echo '<div class="product-body">';
}
function product_after_body_item(){
    echo '</div>';
}
function product_item_cat(){
    echo '<div class="product-cat">
            <a href="#">Mỹ phẩm</a>,
            <a href="#">Làm đẹp</a>
        </div>';
}
function product_item_rate(){
    echo '<div class="ratings-container">
            <div class="ratings">
                <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
            </div><!-- End .ratings -->
            <span class="ratings-text">( 6 Reviews )</span>
        </div>';
}


remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_paging', 'woocommerce_breadcrumb', 10 );
//remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);

add_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );  
//add_action( 'woocommerce_before_main_content', '_item_title' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
    add_action ( 'woocommerce_before_shop_loop' ,  'before_shop_loop');
    add_action ( 'woocommerce_before_shop_loop' ,  'before_shop_toolbox', 10 );    
    add_action ( 'woocommerce_before_shop_loop' ,  'after_shop_toolbox', 50 );

    //-- shop loop itmes
    remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 ); 
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10 );

    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
    
        add_action ( 'woocommerce_before_shop_loop_item' ,  'before_shop_loop_item');
        add_action ( 'woocommerce_before_shop_loop_item' ,  'add_before_figure', 40);

            add_action ( 'woocommerce_before_shop_loop_item_title' ,  'woocommerce_show_product_loop_sale_flash', 10);
            add_action ( 'woocommerce_before_shop_loop_item_title' ,  'woocommerce_template_loop_product_link_open');
            add_action ( 'woocommerce_before_shop_loop_item_title' ,  'woocommerce_template_loop_product_thumbnail');
            add_action ( 'woocommerce_before_shop_loop_item_title' ,  'woocommerce_template_loop_product_link_close');
            add_action ( 'woocommerce_before_shop_loop_item_title' ,  'product_action_vertical');
            
        add_action ( 'woocommerce_before_shop_loop_item_title' ,  'add_after_figure', 20); 

        add_action ( 'woocommerce_shop_loop_item_title' ,  'product_before_body_item', 0);
        add_action ( 'woocommerce_shop_loop_item_title' ,  'product_item_cat', 1);
        
        add_action ( 'woocommerce_after_shop_loop_item_title' ,  'product_item_rate', 20);
        add_action ( 'woocommerce_after_shop_loop_item_title' ,  'product_after_body_item', 30);

        add_action ( 'woocommerce_after_shop_loop_item' ,  'after_shop_loop_item');

    add_action ( 'woocommerce_after_shop_loop' ,  'after_shop_loop');

add_action ( 'woocommerce_output_content_wrapper_end' ,  '_output_content_wrapper_end', 50);



add_action( 'woocommerce_after_shop_loop_item', 'remove_add_to_cart_buttons', 1 );
function remove_add_to_cart_buttons() { 
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' ); 
}


add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );

//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

//remove_action
//add_action('woocommerce_sidebar','_get_sidebar');
 
/**
 * for product loop
 */

 function woocommerce_template_loop_product_title() {
    global $product;
    $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
	echo '<h3 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'product-title' ) ) . '">  <a href="' . esc_url( $link ) . '">' . get_the_title() . '</a></h3>';
}



//------------- 

?>