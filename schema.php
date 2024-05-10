<?php

/**
 * 1. home
 * 2. About us
 * 3. News
 * 4. Contact
 * 5. Shop
 * 
 */

return [
    'sessions' => [
        ['name' => 'general', 'title' => 'Tổng quan'],
        ['name' => 'menu', 'title' => 'Menus'],
        ['name' => 'home', 'title' => 'Trang chủ'],
        ['name' => 'about-us', 'title' => 'Về chúng tôi'],
    ],

    'options' => [

        // SITE NAME
        [
            'session' => 'general',
            'type' => 'text',
            'name' => 'site_name',
            'label' => 'Tên webiste',
            'default' => 'vBrand Theme One',
        ],

        // SIDE LOGO
        [
            'session' => 'general',
            'type' => 'image',
            'name' => 'site_logo',
            'label' => 'Site logo',
            'default' => null,
        ],
        // Menus
        [
            'session' => 'menu',
            'type' => 'list',
            'name' => 'menus',
            'label' => 'Menus',
            'max' => 10,
            'default' => [
                [
                    'show' => true,
                    'title' => 'Trang chủ',
                    'type' => 'page-homepage.php',
                ],
                [
                    'show' => true,
                    'title' => 'Về chúng tôi',
                    'type' => 'page-aboutus.php',
                ],

                [
                    'show' => true,
                    'title' => 'Gian hàng',
                    'type' => 'shop',
                ],
                [
                    'show' => true,
                    'title' => 'Tin tức',
                    'type' => 'page-news.php',
                ],
                [
                    'show' => true,
                    'title' => 'Liên hệ',
                    'type' => 'page-contact.php',
                ],

            ],
            'schema' => [
                // show
                [
                    'type' => 'boolean',
                    'name' => 'show',
                    'label' => 'Hiển thị',
                    'default' => true,
                ],
                [
                    'type' => 'text',
                    'name' => 'title',
                    'label' => 'Tên menu',
                    'default' => '',
                ],
                [
                    'type' => 'select',
                    'name' => 'type',
                    'label' => 'Chọn Loại Menu',
                    'default' => '',
                    'options' => [
                        ['value' => 'page-homepage.php', 'text' => 'Home'],
                        ['value' => 'page-aboutus.php', 'text' => 'About Us'],
                        ['value' => '', 'text' => 'Shop'],
                        ['value' => 'page-news.php', 'text' => 'News'],
                        ['value' => 'page-contact', 'text' => 'Contact Us'],
                    ],
                ],
            
            ],
        ],
        // BANNER
        [
            'session' => 'home',
            'type' => 'image',
            'name' => 'banner_image',
            'label' => 'Banner Image',
            'default' => get_template_directory_uri() . '/images/couch.png',
        ],
        [
            'session' => 'home',
            'type' => 'textarea',
            'name' => 'banner_title',
            'label' => 'Banner Title',
            'default' => 'Thiết kế nội thất<span clsas="d-block">hiện đại</span>',
        ],
        [
            'session' => 'home',
            'type' => 'textarea',
            'name' => 'banner_description',
            'label' => 'Banner Description',
            'default' => 'Thiết kế nội thất hiện đại kết hợp sự tiện nghi và thẩm mỹ, tập trung vào sự đơn giản, linh hoạt và sử dụng tối đa ánh sáng tự nhiên. Vật liệu công nghệ cao như kính, thép không gỉ được ưa chuộng, tạo không gian mở rộng và hiện đại. Màu sắc trung tính kết hợp với điểm nhấn màu sắc táo bạo, đèn led và ánh sáng mềm mại tạo điểm nhấn và sự ấm áp cho không gian. Thiết kế này không chỉ tiện nghi mà còn thể hiện phong cách và cá nhân của gia chủ.',
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'banner_main_button_link',
            'label' => 'Banner Main Button Link',
            'default' => '',
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'banner_main_button_text',
            'label' => 'Banner Main Button Text',
            'default' => 'Xem ngay',
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'banner_second_button_link',
            'label' => 'Banner Second Button Link',
            'default' => '',
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'banner_second_button_text',
            'label' => 'Banner Second Button Text',
            'default' => 'Explore',
        ],
        
        // PRODUCTS MODULE
        [
            'session' => 'home',
            'type' => 'boolean',
            'name' => 'products_module_show',
            'label' => 'Show Products Module',
            'default' => true,
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'products_module_title',
            'label' => 'Products Module Title',
            'default' => 'SẢN PHẨM MỚI',
        ],
        [
            'session' => 'home',
            'type' => 'textarea',
            'name' => 'products_module_description',
            'label' => 'Products Module Description',
            'default' => 'Mẫu sản phẩm mới nhất được chúng tôi cập nhật hàng ngày',
        ],
        [
            'session' => 'home',
            'type' => 'select',
            'name' => 'products_module_type',
            'label' => 'Products Module: Type',
            'default' => 'all',
            'options' => [
                ['value' => 'all', 'text' => 'Mặc định'],
                ['value' => 'hot', 'text' => 'Hot'],
                ['value' => 'feature', 'text' => 'Feature'],
                ['value' => 'new', 'text' => 'New'],
            ],
        ],
        [
            'session' => 'home',
            'type' => 'select',
            'name' => 'products_module_number',
            'label' => 'Products Module: Number of Products',
            'default' => 3,
            'options' => [
                ['value' => 2, 'text' => 2],
                ['value' => 3, 'text' => 3],
                ['value' => 5, 'text' => 5],
            ],
        ],

        // WHY US MODULE
        [
            'session' => 'home',
            'type' => 'boolean',
            'name' => 'why_us_module_show',
            'label' => 'Show Why Us Module',
            'default' => true,
        ],
        [
            'session' => 'home',
            'type' => 'image',
            'name' => 'why_us_module_banner',
            'label' => 'Why Us Module: Banner',
            'default' => get_template_directory_uri() . '/images/why-choose-us-img.jpg',
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'why_us_module_title',
            'label' => 'Why Us Module Title',
            'default' => 'Tại sao Chọn Chúng Tôi',
        ],
        [
            'session' => 'home',
            'type' => 'textarea',
            'name' => 'why_us_module_description',
            'label' => 'Why Us Module Description',
            'default' => 'chúng tôi mang lại sự kết hợp hoàn hảo giữa thiết
                kế độc đáo và chất lượng xuất sắc. Chúng tôi tôn trọng nguyên
                liệu tự nhiên và sử dụng chúng để tạo ra những sản phẩm nội thất đẹp mắt và bền bỉ.',
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'why_us_module_block_1_title',
            'label' => 'Why Us Module: Block 1 Title',
            'default' => 'Nhanh & Vận chuyển Free',
        ],
        [
            'session' => 'home',
            'type' => 'textarea',
            'name' => 'why_us_module_block_1_description',
            'label' => 'Why Us Module: Block 1 Description',
            'default' => 'Vận chuyển nhanh chóng, không phát sinh chi phí vì dịch vụ hoàn toàn miễn phí',
        ],
        [
            'session' => 'home',
            'type' => 'image',
            'name' => 'why_us_module_block_1_icon',
            'label' => 'Why Us Module: Block 1 Icon',
            'default' => get_template_directory_uri() . '/images/truck.svg',
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'why_us_module_block_2_title',
            'label' => 'Why Us Module: Block 2 Title',
            'default' => 'Nhanh & Vận chuyển Free',
        ],
        [
            'session' => 'home',
            'type' => 'textarea',
            'name' => 'why_us_module_block_2_description',
            'label' => 'Why Us Module: Block 2 Description',
            'default' => 'Vận chuyển nhanh chóng, không phát sinh chi phí vì dịch vụ hoàn toàn miễn phí',
        ],
        [
            'session' => 'home',
            'type' => 'image',
            'name' => 'why_us_module_block_2_icon',
            'label' => 'Why Us Module: Block 2 Icon',
            'default' => get_template_directory_uri() . '/images/bag.svg',
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'why_us_module_block_3_title',
            'label' => 'Why Us Module: Block 3 Title',
            'default' => '24/7 Hỗ trợ',
        ],
        [
            'session' => 'home',
            'type' => 'textarea',
            'name' => 'why_us_module_block_3_description',
            'label' => 'Why Us Module: Block 3 Description',
            'default' => 'Chúng tôi Luôn luôn ở đây, 24/7. Hãy tin tưởng chúng tôi khi bạn cần gấp.',
        ],
        [
            'session' => 'home',
            'type' => 'image',
            'name' => 'why_us_module_block_3_icon',
            'label' => 'Why Us Module: Block 3 Icon',
            'default' => get_template_directory_uri() . '/images/support.svg',
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'why_us_module_block_4_title',
            'label' => 'Why Us Module: Block 4 Title',
            'default' => 'Thiết kế sáng tạo, hiện đại',
        ],
        [
            'session' => 'home',
            'type' => 'textarea',
            'name' => 'why_us_module_block_4_description',
            'label' => 'Why Us Module: Block 4 Description',
            'default' => 'Với nhiều thiết kế đẹp, sáng tạo, luôn mang đến cho bạn sức sống mới.',
        ],
        [
            'session' => 'home',
            'type' => 'image',
            'name' => 'why_us_module_block_4_icon',
            'label' => 'Why Us Module: Block 4 Icon',
            'default' => get_template_directory_uri() . '/images/return.svg',
        ],

        
        // OURS project
        [
            'session' => 'home',
            'type' => 'boolean',
            'name' => 'our_project_module_show',
            'label' => 'Show Our Project Module',
            'default' => true,
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'our_project_module_title',
            'label' => 'Our Project Module Title',
            'default' => 'Dự án',
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'our_project_module_alias',
            'label' => 'Our Project Module Alias',
            'default' => 'Dự án đã triển khai',
        ],
        [
            'session' => 'home',
            'type' => 'text',
            'name' => 'our_project_module_description',
            'label' => 'Our Project Module Description',
            'default' => 'Trải nghiệm các dự án do chúng tôi trực tiếp thiết kế và thi công',
        ],
        [
            'session' => 'home',
            'type' => 'image',
            'name' => 'our_project_project_1',
            'label' => 'Our Project Module: Project 1',
            'default' => get_template_directory_uri() . '/images/project-1.jpg',
        ],
        [
            'session' => 'home',
            'type' => 'image',
            'name' => 'our_project_project_2',
            'label' => 'Our Project Module: Project 2',
            'default' => get_template_directory_uri() . '/images/project-2.jpg',
        ], 


        // ARTICLES
        [
            'session' => 'home',
            'type' => 'boolean',
            'name' => 'articles_module_show',
            'label' => 'Show Articles Module',
            'default' => true,
        ],
        [
            'session' => 'home',
            'type' => 'select',
            'name' => 'articles_module_number',
            'label' => 'Articles Module: Number of Articles',
            'default' => 3,
            'options' => [
                ['value' => 2, 'text' => 2],
                ['value' => 3, 'text' => 3],
                ['value' => 4, 'text' => 4],
            ],
        ],
        [
            'session' => 'home',
            'type' => 'select',
            'name' => 'articles_module_sort',
            'label' => 'Articles Module: Sort',
            'default' => 'newest',
            'options' => [
                ['value' => 'newest', 'text' => 'Newest'],
                ['value' => 'oldest', 'text' => 'Oldest'],
            ],
        ],

        // FOOTER
        [
            'session' => 'general',
            'type' => 'textarea',
            'name' => 'copyright_line',
            'label' => 'Copyright Line',
            'default' => '© 2017–2023 vBrand Company, Inc. · <a href="#" class="fw-semibold">Privacy</a> · <a href="#" class="fw-semibold">Terms</a>',
        ],

        // FOOTER LOGO
        [
            'session' => 'general',
            'type' => 'image',
            'name' => 'footer_logo',
            'label' => 'Footer Logo',
            'default' => get_template_directory_uri() . '/images/sofa.png',
        ],
        
        // FOOTER LOGO
        [
            'session' => 'general',
            'type' => 'image',
            'name' => 'aboutus_image',
            'label' => 'Image About Us',
            'default' => get_template_directory_uri() . '/images/why-choose-us-img.jpg',
        ],

        // ABOUT US
        [
            'session' => 'about-us',
            'type' => 'boolean',
            'name' => 'about_us_show',
            'label' => 'Show About Us Module',
            'default' => true,
        ],
        [
            'session' => 'about-us',
            'type' => 'text',
            'name' => 'aboutus_title',
            'label' => 'About Us title',
            'default' => 'Giới thiệu',
        ],
        [
            'session' => 'about-us',
            'type' => 'textarea',
            'name' => 'aboutus_content',
            'label' => 'About Us content',
            'default' => '<p>chúng tôi mang lại sự kết hợp hoàn hảo giữa thiết kế độc đáo và chất lượng xuất sắc. Chúng tôi tôn trọng nguyên liệu tự nhiên và sử dụng chúng để tạo ra những sản phẩm nội thất đẹp mắt và bền bỉ. </p>   ',
        ],
    ],
];