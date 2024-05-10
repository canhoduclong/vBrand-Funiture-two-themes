<?php
/*
Template Name: Product Search
*/

get_header();

// Your custom search form can be added here

// The WordPress loop to display search results
if (have_posts()) :
    while (have_posts()) : the_post();
        // Your search result display code here
        the_title('<h2>', '</h2>');
        the_content();
    endwhile;
else :
    echo '<p>No products found.</p>';
endif;

get_footer();
