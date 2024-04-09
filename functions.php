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
function theme_breadcrumbs() {
    // Define the home icon and text
    $home_icon = '<i class="fa fa-home"></i>';
    $home_text = 'Home';

    // Start the breadcrumb output
    echo '<div class="breadcrumbs">';
    echo '<a href="' . home_url() . '">' . $home_icon . ' ' . $home_text . '</a>';

    // Check if it's a single post (single.php) or a page
    if (is_single() || is_page()) {
        $post_type = get_post_type();
        $post_type_object = get_post_type_object($post_type);

        // Display category and parent pages for posts
        if ($post_type === 'post') {
            $categories = get_the_category();
            if (!empty($categories)) {
                $category = $categories[0];
                echo '<span class="sep"> &raquo; </span>';
                echo '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
            }
        }

        // Display parent pages for pages
        elseif ($post_type === 'page') {
            $ancestors = get_post_ancestors(get_the_ID());
            if (!empty($ancestors)) {
                $ancestors = array_reverse($ancestors);
                foreach ($ancestors as $ancestor) {
                    echo '<span class="sep"> &raquo; </span>';
                    echo '<a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>';
                }
            }
        }

        // Display the current post or page title
        echo '<span class="sep"> &raquo; </span>';
        echo '<span class="current">' . get_the_title() . '</span>';
    }

    // Display the category for category archives
    elseif (is_category()) {
        $category = get_queried_object();
        echo '<span class="sep"> &raquo; </span>';
        echo '<span class="current">' . $category->name . '</span>';
    }

    // Display the tag for tag archives
    elseif (is_tag()) {
        $tag = get_queried_object();
        echo '<span class="sep"> &raquo; </span>';
        echo '<span class="current">' . $tag->name . '</span>';
    }

    // Display the search term for search results
    elseif (is_search()) {
        echo '<span class="sep"> &raquo; </span>';
        echo '<span class="current">Search results for "' . get_search_query() . '"</span>';
    }

    // Display the date for date archives
    elseif (is_date()) {
        echo '<span class="sep"> &raquo; </span>';
        echo '<span class="current">' . get_the_date() . '</span>';
    }

    // Display the author for author archives
    elseif (is_author()) {
        $author = get_queried_object();
        echo '<span class="sep"> &raquo; </span>';
        echo '<span class="current">Author: ' . $author->display_name . '</span>';
    }

    // Display the custom post type for custom post type archives
    elseif (is_post_type_archive()) {
        $post_type = get_queried_object();
        echo '<span class="sep"> &raquo; </span>';
        echo '<span class="current">' . $post_type->labels->name . '</span>';
    }

    // Display the 404 error page
    elseif (is_404()) {
        echo '<span class="sep"> &raquo; </span>';
        echo '<span class="current">404 Not Found</span>';
    }

    // End the breadcrumb output
    echo '</div>';
}

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
    ));

    // Start the output buffer
    ob_start(); 

    $in_categories = [];

    if(isset($_GET['productcategories'])){
        $in_categories = explode( ',',  $_GET['productcategories'] );
    }
    // Display a checkbox for each category
    echo '<ul class="categories">';
    foreach ($product_categories as $category) {
        echo "<li>";
        echo '<input type="checkbox" name="product_categorie[]" value="' . esc_attr($category->slug) . '" id="' . esc_attr($category->slug) . '"';
        // Check if the category is selected
        if ( in_array($category->slug, $in_categories) ) {
            echo ' checked';
        }   
        echo '>';
        echo '<label class="ml-2" for="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</label>';
        echo "</li>";
    }
    echo "</ul>";

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




?>