<aside id="secondary" class="widget-area">
    <?php dynamic_sidebar('sidebar-1'); ?>
    <div class="widget">
        <h2 class="widget-title">Categories</h2>
        <ul>
            <?php
            $categories = get_categories();
            foreach ($categories as $category) {
                echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="widget">
        <h2 class="widget-title">Tag</h2>
        <?php
        // Lấy danh sách 10 tags phổ biến nhất
        $tags = get_terms(array(
            'taxonomy' => 'post_tag',
            'orderby' => 'count',
            'order' => 'DESC',
            'number' => 10,
        ));

        // Lặp qua từng tag và hiển thị
        foreach ($tags as $tag) {
            echo '<a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a><br>';
        }
        ?>
    </div>
</aside>

 

