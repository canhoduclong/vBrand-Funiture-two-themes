<?php
    $themeData = vbrand_load_theme_data();
?>
<!doctype html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         
        <title><?php echo $themeData->get('site_name', 'Shop Funiture'); ?></title>
        <meta name="keywords" content="<?php echo $themeData->get('site_name', 'Shop Funiture'); ?>">
        <meta name="description" content="<?php echo $themeData->get('site_desctiption', 'Shop Funiture plays a crucial role in shaping the ambiance and functionality of retail spaces'); ?>">
        <meta name="author" content="vBrand">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="<?=get_template_directory_uri()?>/assets/images/icons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?=get_template_directory_uri()?>/assets/images/icons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?=get_template_directory_uri()?>/assets/images/icons/favicon-16x16.png">
        <link rel="manifest" href="<?=get_template_directory_uri()?>/assets/images/icons/site.html">
        <link rel="mask-icon" href="<?=get_template_directory_uri()?>/assets/images/icons/safari-pinned-tab.svg" color="#666666">
        <link rel="shortcut icon" href="<?=get_template_directory_uri()?>/assets/images/icons/favicon.ico">
        <meta name="apple-mobile-web-app-title" content="Molla">
        <meta name="application-name" content="Molla">
        <meta name="msapplication-TileColor" content="#cc9966">
        <meta name="msapplication-config" content="<?=get_template_directory_uri()?>/assets/images/icons/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">

        <?php wp_head(); ?>

        <link rel="stylesheet" href="<?=get_template_directory_uri()?>/assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css">
        
        <!-- Plugins CSS File -->
        <link rel="stylesheet" href="<?=get_template_directory_uri()?>/assets/css/bootstrap.min.css">
  

        <!-- Main CSS File -->
        <link rel="stylesheet" href="<?=get_template_directory_uri()?>/assets/css/style.css">
        <link rel="stylesheet" href="<?=get_template_directory_uri()?>/assets/css/plugins/owl-carousel/owl.carousel.css">
        <link rel="stylesheet" href="<?=get_template_directory_uri()?>/assets/css/plugins/magnific-popup/magnific-popup.css">
        <link rel="stylesheet" href="<?=get_template_directory_uri()?>/assets/css/plugins/nouislider/nouislider.css">
        <link rel="stylesheet" href="<?=get_template_directory_uri()?>/assets/css/demos/demo-11.css">
        
    </head>
    <body>
        <div class="page-wrapper">
            <header class="header">
                <div class="header-middle sticky-header">
                    <div class="container">
                        
                        <div class="header-left">
                            <button class="mobile-menu-toggler">
                                <span class="sr-only">Toggle mobile menu</span>
                                <i class="icon-bars"></i>
                            </button>

                            <a class="logo" href="<?php echo home_url('/');?>">
                                <?php if ($themeData->get('site_logo')) { ?>
                                    <img src="<?php echo $themeData->get('site_logo'); ?>"  width="82" height="25">
                                <?php } else { ?>
                                    Shop Funiture
                                <?php } ?> 
                            </a>
                            <nav class="main-nav">
                                <ul class="menu sf-arrows">

                                    <?php 
                                    foreach ($themeData->get('menus') as $key => $menu) {
                                        if ($menu['show'] == 'true') {
                                            if ($menu['type'] == 'page-homepage.php')
                                            {
                                                $page = vbrand_getOrCreatePageByTemplate('page-homepage.php');
                                                $menuLink = get_permalink( $page->ID );

                                            }else if ($menu['type'] == 'page-aboutus.php')
                                            {
                                                $page = vbrand_getOrCreatePageByTemplate('page-aboutus.php');
                                                $menuLink = get_permalink( $page->ID );

                                            } else if ($menu['type'] == 'shop') {
                                                if (class_exists('WooCommerce')) {
                                                    if(get_option( 'woocommerce_shop_page_id' )){
                                                        $menuLink = get_permalink( get_option( 'woocommerce_shop_page_id' ) ); 
                                                    }else{
                                                        echo "không tim thấy trang shop, vui lòng kiểm tra cấu hình của woocomerce";
                                                    }
                                                } else {
                                                    echo "chưa cài WooCommerce";
                                                }
                                            } else if ($menu['type'] == 'page-news.php') {

                                                $page = vbrand_getOrCreatePageByTemplate('page-news.php');
                                                $menuLink = get_permalink( $page->ID );

                                            } else if ($menu['type'] == 'page-contact.php') {
                                                $page = vbrand_getOrCreatePageByTemplate('page-contact.php');
                                                $menuLink = get_permalink( $page->ID );
                                            }
                                        ?>
                                        <li>
                                            <a href="<?= $menuLink ?>">
                                                <?= $menu['title'] ?>
                                            </a>
                                        </li><?php 
                                        }
                                    } ?>
                                </ul>
                            </nav>  
                            
                        </div>
                        <!-- End .header-left -->

                        <div class="header-right">

                          
                            <div class="header-search">
                                <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                                <?php echo do_shortcode('[custom_product_search]'); ?>
                            </div><!-- End .header-search -->
                            
                            <a href="<?php echo home_url('/');?>compare" class="wishlist-link">
                                <i class="icon-compare"></i>
                                    <span class="wishlist-count">0</span>
                            </a>

                            <div class="dropdown cart-dropdown">
                                <a href="<?php echo home_url('/');?>/card" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                    <i class="icon-shopping-cart"></i>
                                    <span class="cart-count">0</span>
                                    <span class="cart-txt">0</span>
                                </a> 

                                <div class="dropdown-menu dropdown-menu-right" id="minicart">
                                    <div id="minicart-content">
                                        <a href="javascript:;" id="close-minicart">×</a>
                                        <div class="dropdown-cart-products" id="minicart-items"> 

                                        </div><!-- End .cart-product -->

                                        <div class="dropdown-cart-total">
                                            <span>Tổng tiền</span>

                                            <span class="cart-total-price" id="minicart-subtotal">00</span>
                                        </div><!-- End .dropdown-cart-total -->

                                        <div class="dropdown-cart-action">
                                            <a href="/cart" class="btn btn-primary">Giỏ hàng</a>
                                            <a href="/checkout" class="btn btn-outline-primary-2"><span>Thanh toán</span><i class="icon-long-arrow-right"></i></a>
                                        </div><!-- End .dropdown-cart-total -->
                                    </div>
                                </div> 
                                <!-- End .dropdown-menu -->
                            </div><!-- End .cart-dropdown -->

                            
                        </div><!-- End .header-right -->
                    </div><!-- End .container -->
                </div><!-- End .header-middle -->
            </header><!-- End .header -->

            <main class="main">