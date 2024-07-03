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
    //if (is_shop() && $query->is_main_query()) {
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
   // }
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



function _product_categories() {
    // Get product categories
    $product_categories = get_terms( 'product_cat', array(
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => true,
    ) );

    // Check if categories are found
    if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {

        echo '<div class="widget widget-collapsible">';
        echo '<h3 class="widget-title">';
        echo '<a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">Sản phẩm</a>';
        echo '</h3>';
        echo '
            <div class="collapse show" id="widget-1">
                <div class="widget-body">
                    <div class="filter-items filter-items-count">'; 

        // Loop through each category
        foreach ( $product_categories as $category ) {
                     echo '<div class="filter-item">';
                    echo '<div class="custom-control custom-checkbox">';
                                echo '<input type="checkbox" class="custom-control-input"  value="' . esc_attr($category->slug) . '" id="' . esc_attr($category->slug) . '">';
                                echo '<label class="custom-control-label" for="'.$category->slug.'">' . esc_html( $category->name ) . '</label>';
                            echo '</div> ';
                           echo ' <span class="item-count">'.$category->count.'</span>';
                        echo '</div> '; 
        }

        echo '
                    </div><!-- End .filter-items -->
                </div><!-- End .widget-body -->
            </div><!-- End .collapse -->
        </div>';
    }
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
    add_action( 'pre_get_posts', 'custom_woocommerce_product_query' );
    add_action( 'woocommerce_sidebar', 'show_attribute_sidebar', 10 ); 
    
});

 
 
/**
 *  woocommerce
 */ 

   


function custom_woocommerce_product_query( $query ) {
    if ( ! is_admin() && $query->is_main_query() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
        if ( isset( $_GET['filter_pa_size'] ) && ! empty( $_GET['filter_pa_size'] ) ) {
            $terms = explode( ',', sanitize_text_field( $_GET['filter_pa_size'] ) );
            $tax_query = (array)$query->get( 'tax_query' );
            $tax_query[] = array(
                'taxonomy' => 'pa_size', // Change 'pa_size' to your attribute
                'field'    => 'slug',
                'terms'    => $terms,
                'operator' => 'IN', // Change operator as per requirement
            );
            // echo "<pre>"; print_r($tax_query); echo "<pre>";
            $query->set( 'tax_query', $tax_query );
        }
           
    }
}

//------- update sortcard
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-minicart', get_template_directory_uri() . '/assets/js/custom-minicart.js', array('jquery'), '1.0', true);
    wp_localize_script('custom-minicart', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function add_product_to_cart() {
    $product_id = intval($_POST['product_id']);
    $quantity = 1; // Set quantity to 1 or modify as needed

    if (WC()->cart->add_to_cart($product_id, $quantity)) {
        $cart_contents = WC()->cart->get_cart();
        $items = array();

        foreach ($cart_contents as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
            $items[] = array(
                'name' => $product->get_name(),
                'quantity' => $cart_item['quantity'],
                'subtotal' => wc_price($cart_item['line_subtotal'])
            );
        }

        wp_send_json_success($items);
    } else {
        wp_send_json_error();
    }
}

add_action('wp_ajax_add_to_cart', 'add_product_to_cart');
add_action('wp_ajax_nopriv_add_to_cart', 'add_product_to_cart');

//------ Remove product from cart 
function remove_from_cart() {
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);

    if (WC()->cart->remove_cart_item($cart_item_key)) {
        $cart_contents = WC()->cart->get_cart();
        $items = array();
        $total_count = WC()->cart->get_cart_contents_count();
        $subtotal = WC()->cart->get_cart_subtotal();

        foreach ($cart_contents as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
            $items[] = array(
                'name' => $product->get_name(),
                'quantity' => $cart_item['quantity'],
                'cart_item_key' => $cart_item_key
            );
        }

        $data = array(
            'items' => $items,
            'total_count' => $total_count,
            'subtotal' => $subtotal
        );

        wp_send_json_success($data);
    } else {
        wp_send_json_error();
    }
}

add_action('wp_ajax_remove_from_cart', 'remove_from_cart');
add_action('wp_ajax_nopriv_remove_from_cart', 'remove_from_cart');
//------ get short cart 
function get_cart_data() {
    $cart_contents = WC()->cart->get_cart();
    $items = array();
    $total_count = WC()->cart->get_cart_contents_count();
    $subtotal = WC()->cart->get_cart_subtotal();

    foreach ($cart_contents as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        $items[] = array(
            'cart_item_key' => $cart_item_key,
            'name' => $product->get_name(),
            'permalink' => $product->get_permalink(),
            'image' => $product->get_image(),
            'price' => $product->get_price(),
            'price_html' => $product->get_price_html(),
            'quantity' => $cart_item['quantity'],
            'subtotal' => wc_price($cart_item['line_subtotal'])
        );
    }

    $data = array(
        'items' => $items,
        'total_count' => $total_count,
        'subtotal' => $subtotal
    );

    wp_send_json_success($data);
    wp_die();
}

add_action('wp_ajax_get_cart_data', 'get_cart_data');
add_action('wp_ajax_nopriv_get_cart_data', 'get_cart_data');




function initial(){
    
    if(is_shop() || is_product_category() || is_product_tag() ) { 
        add_action( 'wp_enqueue_scripts', 'custom_enqueue_scripts' ); 
        /**
         *  archive-product.php
         */
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 20 );
        remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );

        add_action( 'woocommerce_custom_breadcrumb', 'woocommerce_breadcrumb', 10 ); 
        add_action( 'woocommerce_custom_content_wrapper', 'woocommerce_output_content_wrapper', 10 );
        add_action( 'woocommerce_custom_content_wrapper', 'woocommerce_add_row_tag' );
        add_action( 'woocommerce_custom_content_wrapper', 'woocommerce_before_product_tag' );
        
        add_action( 'woocommerce_custom_end_content_wrapper', 'woocommerce_add_end_product_tag' ); 
        
        //------- for sidebar
        add_action( 'woocommerce_sidebar', 'woocommerce_before_sidebar', 0 );
        //add_action( 'woocommerce_sidebar', 'display_product_categories_checkbox', 30 );
        add_action( 'woocommerce_sidebar', '_product_categories', 40 );
        add_action( 'woocommerce_sidebar', 'woocommerce_after_sidebar', 60 );
        add_action('woocommerce_sidebar', 'price_progress_bar', 50);


        add_action ( 'woocommerce_before_shop_loop' ,  'before_shop_toolbox', 10 );
        add_action ( 'woocommerce_before_shop_loop' ,  'after_shop_toolbox', 40 );
        add_action ( 'woocommerce_before_shop_loop' ,  'before_shop_loop', 50);
        add_action ( 'woocommerce_after_shop_loop' ,  'after_shop_loop');

        
        if(isset($_GET['view'])){
            if( $_GET['view'] !='list'){ 
                add_action( 'woocommerce_before_shop_loop',     'woocommerce_add_row_tag', 60 );
                add_action ( 'woocommerce_after_shop_loop' ,    'woocommerce_add_end_row_tag', 60);
            }
        }else{
            add_action( 'woocommerce_before_shop_loop',     'woocommerce_add_row_tag', 60 );
            add_action ( 'woocommerce_after_shop_loop' ,    'woocommerce_add_end_row_tag', 60);
        }

        /**`
         *  content-product.php
         */
        remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 ); 
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10 );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
        
        
        add_action ( 'woocommerce_before_shop_loop_item' ,  'before_shop_loop_item');   //----> Defind List or Grid Products
        
        if(isset($_GET['view'])){
            if( $_GET['view'] =='list'){ 
                list_items();
            }else{
                grid_items();
            }
        }else{
            grid_items();
        }

        add_action ( 'woocommerce_after_shop_loop_item' ,  'after_shop_loop_item' ); 
        
        //--- end content-product.php

        add_action ( 'woocommerce_output_content_wrapper_end' ,  '_output_content_wrapper_end', 50 );
        add_action( 'woocommerce_after_shop_loop_item', 'remove_add_to_cart_buttons', 1 );
       
    }
    if(is_front_page()){
        add_action( 'wp_enqueue_scripts', 'custom_enqueue_scripts' );  

        /**`
         *  content-product.phps
         */
        remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 ); 
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10 );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
        
        
        add_action ( 'woocommerce_before_shop_loop_item' ,  'before_shop_loop_item');   //----> Defind List or Grid Products
        
      
        grid_items();
         

        add_action ( 'woocommerce_after_shop_loop_item' ,  'after_shop_loop_item' ); 
        
        //--- end content-product.php
 
        add_action( 'woocommerce_after_shop_loop_item', 'remove_add_to_cart_buttons', 1 );
         

    }
    if(is_product()){
        add_action( 'wp_enqueue_scripts', 'custom_enqueue_scripts' ); 

        //--- remove default function
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 ); 

        //----- Build Infomation
        add_action( 'woocommerce_custom_breadcrumb', 'woocommerce_breadcrumb', 10 ); 
        add_action( 'woocommerce_before_main_content', 'woocommerce_before_product_details_tag');
        //add_action( 'woocommerce_before_main_content', 'woocommerce_add_row_tag', 30 ); 

        add_action( 'woocommerce_related_product', 'woocommerce_before_product_details_tag' );       
        add_action( 'woocommerce_upsale_product', 'woocommerce_upsell_display', 15 );
        add_action( 'woocommerce_related_product', 'woocommerce_output_related_products' ); 
        
        
    }

}
add_action( 'wp', 'initial');





function list_items(){
    //--- remove default
    remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);


    add_action( 'woocommerce_before_shop_loop_item_title',     'woocommerce_add_row_tag', 1 );
    
    //---- Thunails
    add_action ( 'woocommerce_before_shop_loop_item_title' ,    'list_items_thunails', 10);
    add_action ( 'woocommerce_before_shop_loop_item_title' ,    'woocommerce_template_loop_product_thumbnail', 11);
    add_action ( 'woocommerce_before_shop_loop_item_title' ,    'woocommerce_show_product_loop_sale_flash', 12);
    add_action ( 'woocommerce_before_shop_loop_item_title' ,    'end_tag', 15);

    //----- Product Info
    add_action ( 'woocommerce_before_shop_loop_item_title' ,    'list_items_info', 16);
    add_action ( 'woocommerce_before_shop_loop_item_title' ,        'product_item_cat', 17 );
    add_action ( 'woocommerce_before_shop_loop_item_title' ,        'product_before_body_item', 18 ); 
    add_action ( 'woocommerce_before_shop_loop_item_title' ,        'woocommerce_template_loop_product_title', 19 );  
    add_action ( 'woocommerce_before_shop_loop_item_title' ,        'product_description', 20 );  

    add_action ( 'woocommerce_before_shop_loop_item_title' ,         'product_after_body_item', 30 );
    add_action ( 'woocommerce_before_shop_loop_item_title' ,    'list_items_info_end', 40);

    //----- Action
    add_action ( 'woocommerce_before_shop_loop_item_title' ,    'list_items_action', 50);
    add_action ( 'woocommerce_before_shop_loop_item_title',      'woocommerce_template_loop_price', 51);
    add_action ( 'woocommerce_before_shop_loop_item_title' ,        'product_item_rate', 52 );
    add_action ( 'woocommerce_before_shop_loop_item_title',         'woocommerce_template_loop_add_to_cart', 60 ); 
    add_action ( 'woocommerce_before_shop_loop_item_title' ,    'list_items_action_end',70); 

  
    //add_action ( 'woocommerce_shop_loop_item_title' ,  'product_item_cat', 1 ); 
    add_action ( 'woocommerce_after_shop_loop_item_title' ,    'woocommerce_add_end_row_tag', 60);
}

function grid_items(){
    add_action ( 'woocommerce_before_shop_loop_item_title' ,  'add_before_figure', 0);
    add_action ( 'woocommerce_before_shop_loop_item_title' ,  'woocommerce_show_product_loop_sale_flash', 10);
    add_action ( 'woocommerce_before_shop_loop_item_title' ,  'woocommerce_template_loop_product_link_open');
    add_action ( 'woocommerce_before_shop_loop_item_title' ,  'woocommerce_template_loop_product_thumbnail');
    add_action ( 'woocommerce_before_shop_loop_item_title' ,  'woocommerce_template_loop_product_link_close');
    add_action ( 'woocommerce_before_shop_loop_item_title' ,  'product_action_vertical');    
    add_action ( 'woocommerce_before_shop_loop_item_title' ,  'add_after_figure', 20); 
    add_action ( 'woocommerce_before_shop_loop_item_title',   'woocommerce_template_loop_add_to_cart', 10 ); 


    add_action ( 'woocommerce_shop_loop_item_title' ,  'product_before_body_item', 0 );
    add_action ( 'woocommerce_shop_loop_item_title' ,  'product_item_cat', 1 );
    
    add_action ( 'woocommerce_after_shop_loop_item_title' ,  'product_item_rate', 20 );
    add_action ( 'woocommerce_after_shop_loop_item_title' ,  'product_after_body_item', 30 );

    add_action ( 'woocommerce_after_shop_loop_item' ,  'after_shop_loop_item' ); 
    
    //--- end content-product.php 
}

//------- Element layout
function list_items_thunails(){
    echo '<div class="col-6 col-lg-3">';
}
function list_items_info(){
    echo '<div class="col-lg-6"> <div class="product-body product-action-inner">';
}
function list_items_info_end(){
    echo '</div></div>';
}
function list_items_action(){
    echo '<div class="col-6 col-lg-3 order-lg-last"><div class="product-list-action">';
}
function list_items_action_end(){
    echo '</div></div>';
}
function end_tag(){
    echo '</div>';
}

/**
 * ---- functions
 */

function vn_to_str ($str){
    $unicode = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',     
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',     
        'i'=>'í|ì|ỉ|ĩ|ị',     
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',     
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',     
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',     
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',     
        'D'=>'Đ',     
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',     
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',     
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',     
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',     
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',     
    );
    foreach($unicode as $nonUnicode=>$uni){     
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);     
    }
    $str = str_replace(' ','_',$str);     
    return $str;
}

function remove_add_to_cart_buttons() { 
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' ); 
}

/**
 * ------------- SideBar
 */
function color_pattern($color ='', $selected = false){
    
    $taxonomy = 'pa_color'; 
    $link = add_query_arg( 'filter_' . esc_attr( $taxonomy ), esc_attr( $color ), get_permalink( wc_get_page_id( 'shop' ) ) );

    $result = [];
    
    $color = trim($color);
    
    $vang   = array("cam", "vàng", "vang"   );
    $do     = array("Đỏ", "Đỏ bi", "đỏ", "do"  );
    $green  = array("green", "Xanh lá", "xanh la", "xanh lá", 'Green');
    $blue   = array("xanh", 'Xanh', "blue", "xanh da troi", "Xanh da trời", "Xanh Lam");
    $den    = array("Đen", "DEN", "den", "black");
    $hong   = array("hồng", "Hồng", "Pink", "pink");
    $nau    = array("Nâu Đen", "Nâu", "nau", "nâu");

    if( in_array($color, $vang ) ){ 
        return '<a href="'.$link.'" data-color="vang" class="clcolor '. ($selected ? ' selected' :'').'" style="background: #f0c04a;"><span class="sr-only">Color Name</span></a>';
    }
    if( in_array($color, $do ) ){
        return '<a href="'.$link.'" data-color="do" class="clcolor '. ($selected ? ' selected' :'').'" style="background: #cc3333;"><span class="sr-only">Color Name</span></a>';
    }
    if( in_array($color, $green ) ){
        return '<a href="'.$link.' data-color="green" class="clcolor '. ($selected ? ' selected' :'').'" style="background: #669933;"><span class="sr-only">Color Name</span></a>';
    }
    if( in_array($color, $blue ) ){
        return '<a href="javascript:;" data-color="blue" class="clcolor '. ($selected ? ' selected' :'').'" style="background: #3399cc;"><span class="sr-only">Color Name</span></a>';
    }
    if( in_array($color, $den ) ){
        return '<a href="javascript:;" data-color="den" class="clcolor '. ($selected ? ' selected' :'').'" style="background: #333333;"><span class="sr-only">Color Name</span></a>';
    }
    if( in_array($color, $hong ) ){
        return '<a href="javascript:;" data-color="hong" class="clcolor '. ($selected ? ' selected' :'').'" style="background: #f2719c;"><span class="sr-only">Color Name</span></a>';
    }
    if( in_array($color, $nau ) ){
        return '<a href="javascript:;" data-color="nau" class="clcolor '. ($selected ? ' selected' :'').'" style="background: #b87145;"><span class="sr-only">Color Name</span></a>';
    } 

    return '<a href="javascript:;" data-color="xam" class="clcolor '. ($selected ? ' selected' :'').'" style="background: #ebebeb;"><span class="sr-only">Color Name</span></a>';
}
function get_all_attributes(){  
    if ( class_exists( 'WooCommerce' ) ) {   
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1, // Get all products
            'post_status' => 'publish',
        );
        $products = get_posts( $args );
        $all_attributes = [];
        // Loop through each product
        foreach ( $products as $product_post ) {
            $_pf = new WC_Product_Factory();
            $product = $_pf->get_product( $product_post->ID );
            //$product = wc_get_product( $product_post->ID );
            $product_id = $product->get_id();
            $product_name = $product->get_name();
            $product_attributes = $product->get_attributes();
            if ( ! empty( $product_attributes ) ) {
                foreach ( $product_attributes as $attribute ) {
                    $attributes_name = wc_attribute_label( $attribute->get_name() );
                    $attributes_options = $attribute->get_options();
                    $all_attributes[$attributes_name][]= $attributes_options;
                }
            }
        }
        return $all_attributes;
    }
}
function show_attribute_sidebar(  ){
    
    $sidebar = '';
    $sizes = [];
    $colors = [];
    $attribute_array =  get_all_attributes();
    foreach($attribute_array as $key => $attribute_options ){       
        if($key =='Kích thước'  || $key == 'size' ){
            foreach($attribute_options as $attribute_option ){
                foreach($attribute_option as $option )
                $sizes[] = $option;
            }
        }elseif($key =='color'  || $key == 'Màu sắc'){
            foreach($attribute_options as $attribute_option ){
                foreach($attribute_option as $option )
                $colors[] = $option;
            } 
        }
    }

    //---- array unique

    $attribute_sizes = array_unique($sizes);
    $attribute_colors = array_unique($colors);
    
    $sidebar .= '<div class="widget widget-collapsible">
                    <h3 class="widget-title">
                        <a data-toggle="collapse" href="#widget-12" role="button" aria-expanded="true" aria-controls="widget-12">
                        Kích thước
                        </a>
                    </h3>';
    if($attribute_sizes){
        $sidebar .= '<div class="collapse show" id="widget-12">
                        <div class="widget-body">
                            <div class="filter-items">';
        $taxonomy_size = 'pa_size';
        foreach($attribute_sizes as $key => $size){

            $checked = isset( $_GET['filter_' . esc_attr( $taxonomy_size )] ) && in_array( $size,   explode(',',($_GET['filter_' . esc_attr( $taxonomy_size )] )  ) ) ? ' checked' : '';

            $sidebar .= '<div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input size-filter-checkbox"  data-term="' . $size  . '" id="size-'.$key.'"  ' . $checked . '>
                                <label class="custom-control-label" for="size-'.$key.'">'.$size.'</label>
                            </div>
                        </div>';
        }
        $sidebar .= '</div></div></div>';
    }
    $sidebar .= '</div>';

    //------ Color Filter
    $sidebar .= '<div class="widget widget-collapsible">
                    <h3 class="widget-title">
                        <a data-toggle="collapse" href="#widget-22" role="button" aria-expanded="true" aria-controls="widget-22">
                            Màu sắc
                        </a>
                    </h3>';
    if($attribute_colors){
        $sidebar .= '<div class="collapse show" id="widget-22">
                        <div class="widget-body">
                            <div class="filter-colors">';
        $color_list = [];
        $taxonomy_color = 'pa_color';
        //print_r( explode(',',($_GET['filter_' . esc_attr( $taxonomy_color )] )  ) );
        foreach($attribute_colors as $color){
            $color = strtolower(vn_to_str($color));
            //echo $color."<br />";
            $checked = isset( $_GET['filter_' . esc_attr( $taxonomy_color )] ) && in_array( $color,   explode(',',($_GET['filter_' . esc_attr( $taxonomy_color )] )  ) ) ? true : false;
            $color_list[] = color_pattern($color,  $checked);
        }
        $colorlist = array_unique($color_list );
        $sidebar .= join('', $colorlist);
        $sidebar .= '</div></div></div>';
    }
    $sidebar .= '</div>';
    echo $sidebar;     
}

function price_progress_bar() {
    // Get the minimum and maximum prices of products
    global $wpdb;
    $min_price = $wpdb->get_var("SELECT MIN(meta_value + 0) FROM {$wpdb->postmeta} WHERE meta_key='_price'");
    $max_price = $wpdb->get_var("SELECT MAX(meta_value + 0) FROM {$wpdb->postmeta} WHERE meta_key='_price'");

    // Calculate the current range
    $current_range = (isset($_GET['min_price']) && isset($_GET['max_price'])) ? [$_GET['min_price'], $_GET['max_price']] : [$min_price, $max_price];

    if ($min_price !== null && $max_price !== null) {
        $min_price = floatval($min_price);
        $max_price = floatval($max_price);
        $current_min = floatval($current_range[0]);
        $current_max = floatval($current_range[1]);

        // Calculate the progress
        $total_range = $max_price - $min_price;
        $current_progress = ($current_max - $current_min) / $total_range * 100;
        echo '<div class="widget widget-collapsible">
            <h3 class="widget-title">
                <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                    Giá
                </a>
            </h3>
            <div class="collapse show" id="widget-5">
                <div class="widget-body">
                    <div class="filter-price">
                        <div class="filter-price-text">
                            Khoảng giá:
                            <span id="filter-price-range"></span>
                        </div>

                        <div id="price-slider"></div>
                    </div>
                </div>
            </div>
        </div>';
        /*
        echo '<div class="widget widget-collapsible">
                <h3 class="widget-title">
                    <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                        Price
                    </a>
                </h3>';
            echo '<div class="price-progress-bar">';
            echo '<h2>Price Range</h2>';
            echo '<div class="progress-bar-wrapper">';
            echo '<span class="min-price">Min: ' . wc_price($min_price) . '</span>';
            echo '<span class="max-price">Max: ' . wc_price($max_price) . '</span>';
            echo '<div class="progress-bar">';
            echo '<div class="progress" style="width:' . esc_attr($current_progress) . '%;"></div>';
            echo '</div>';
            echo '<span class="current-range">Current: ' . wc_price($current_min) . ' - ' . wc_price($current_max) . '</span>';
            echo '</div>';
            echo '</div>';

        echo '</div>';
        */
    }
}

function woocommerce_template_loop_product_title() {
    global $product;
    $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
    echo '<h3 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'product-title' ) ) . '">  <a href="' . esc_url( $link ) . '">' . get_the_title() . '</a></h3>';
}
function custom_enqueue_scripts() {
    wp_enqueue_script( 'custom-size-filter', get_template_directory_uri() . '/assets/js/custom-size-filter.js', array('jquery'), null, true );
    wp_enqueue_script( 'custom', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), null, true );
} 

function get_current_page_slug() {
    global $post;
    if (isset($post)) { 
        return $post->post_name;
    }
    return null;
}
function woocommerce_before_product_details_tag() { 
    echo   '<div class="product-details-top mb-2">';
}
function woocommerce_before_product_tag() { 
    echo   '<div class="col-lg-9">';
}
function woocommerce_after_product_tag() { 
    echo   '</div>';
}
function woocommerce_add_end_row_tag() { 
    echo   '</div>';
} 
function woocommerce_add_row_tag() {  
    echo   '<div class="row">'; 
}
function woocommerce_before_sidebar() { 
    echo   '<aside class="col-lg-3 order-lg-first"> <div class="sidebar sidebar-shop">'; 
}
function woocommerce_after_sidebar() { 
    echo   '</div></aside>'; 
}

function before_shop_loop (){ 
    if ( is_shop() || is_product_category() || is_product_tag() ) { 
        if(isset($_GET['view'])){
            if( $_GET['view'] =='list'){
                echo '<div class="products mb-3">'; 
            }else{ 
                echo '<div class="products mb-3">';
            } 
        }else{
            echo '<div class="products mb-3">';
        }
    }
}
function after_shop_loop (){ 
    if ( is_shop() || is_product_category() || is_product_tag() ) { 
        if(isset($_GET['view'])){
            if( $_GET['view'] =='list'){
                    echo '</div>'; 
            }else{ 
                echo '</div>';
            } 
        }else{
            echo '</div>';
        }
    }
}

function before_shop_loop_item (){ 
    
    if ( is_shop() || is_product_category() || is_product_tag() ) { 
        if(isset($_GET['view'])){
           if( $_GET['view'] =='list'){ 
                echo '<div class="product product-list">';
            }else{   
                $cols= isset($_GET['grid']) ? $_GET['grid'] : 2;
                
                if($cols){
                    switch($cols){
                        case '2':
                            echo '<div class="col-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="product product-7 text-center"> ';
                            break;
                        case '3':
                            echo '<div class="col-6 col-md-4 col-lg-4 col-xl-4">
                                <div class="product product-7 text-center"> ';
                            break;
                        case 4:
                            echo '<div class="col-6 col-md-3 col-lg-3 col-xl-3">
                                <div class="product product-7 text-center"> ';
                            break;
                        default:
                            echo '<div class="col-6 col-md-4 col-lg-4 col-xl-4">
                                <div class="product product-7 text-center"> ';
                            break;
                    }
                }
            }
        }else{
            echo '<div class="col-6 col-md-4 col-lg-4 col-xl-4">
            <div class="product product-7 text-center"> '; 
        }
        
    }elseif(is_front_page()){
        echo '<div class="col-4 col-md-3 col-lg-3 col-xl-3">
                 <div class="product product-7 text-center"> ';
    }else{

    }
     
}

function after_shop_loop_item(){  
    if ( is_shop() || is_product_category() || is_product_tag() ) {  
        if(isset($_GET['view'])){
           if( $_GET['view'] =='list'){ 
            echo '</div>';
            }else{   
                $cols= isset($_GET['grid']) ? $_GET['grid'] : 2;
                echo '</div></div>'; 
            }
        }else{
            echo '</div></div>';
        } 
    }elseif(is_front_page()){
            echo '</div>';
        echo '</div>';
    }else{
         
    }
}

function add_before_figure(){
    echo '<figure class="product-media">';
}
function add_after_figure(){
    echo '</figure>';
}
function _output_content_wrapper_end (){ 
    echo '</div>'; 
}
function woocommerce_add_end_product_tag (){ 
    echo '</div>'; 
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
    global $product; 
    $terms = get_the_terms( $product->get_id(), 'product_cat' );
    if ( $terms && ! is_wp_error( $terms ) ) {
        echo '<div class="product-cat">';
        foreach ( $terms as $key => $term ) {
            $term_link = get_term_link( $term );
            if ( ! is_wp_error( $term_link ) ) {
                echo '<a href="' . esc_url( $term_link ) . '" class="product-category">' . esc_html( $term->name ) . '</a>';
                echo  $key < 1 ? ', ':'';
            }
        }
        echo '</div>';
    } 
}
function product_description() {
    global $product;
    
    if ( ! $product ) {
        return;
    }

    $description = $product->get_short_description();

    if ( ! empty( $description ) ) {
        echo '<div class="product-content">';
        echo wp_kses_post( $description ); // Ensure the description is output safely
        echo '</div>';
    }
}
 
function product_item_rate(){   
    echo    '<div class="ratings-container">
                <div class="ratings">
                    <div class="ratings-val" style="width: 80%;"></div>
                </div>
                <span class="ratings-text">( 6 Reviews )</span>
            </div>';
}
/**
 * Search area
 */
function search_by_attributes( $query ) {       
    
    // Cancel if search is in admin panel or not for products
    if(is_admin() || $query->get( 'post_type' ) != 'product' )
        return $query;
    
    if ((is_shop() || is_product_category() || is_product_tag()) && !is_admin() && $query->is_main_query()) {
        
        // Cancel if search term is empty   
        if(isset($_GET['filter_pa_size']) && !empty($_GET['filter_pa_size'])){
             
            $meta_query = array('relation' => 'OR'); 
            $meta_query[] = array(
                'taxonomy'     => 'pa_size', 
                'field'    => 'slug',
                'terms'    => $_GET['filter_pa_size'],
                'operator' => 'IN',
            
            );            
            $query->set('meta_query',$meta_query );             
        }   
        return $query;
    }
   
}
add_filter('pre_get_posts','search_by_attributes');
/*
    --- dang lam 
*/
function product_item_rate_updating() {
    global $product;
    if ( ! $product ) {
        return;
    }
    if ( wc_review_ratings_enabled() ) {
        echo wc_get_rating_html( $product->get_average_rating() ); // WooCommerce function to display the rating
    }
}


// Thêm breadcrumb vào trang checkout
add_action('woocommerce_before_checkout_form', 'add_breadcrumb_to_checkout_page', 10);

function add_breadcrumb_to_checkout_page() {
    if (function_exists('woocommerce_breadcrumb')) {
        woocommerce_breadcrumb();
    }
}


?>