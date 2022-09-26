<?php

/*
 * Setup global Woocommerce container
 */

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'io_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'io_wrapper_end', 10);

function io_wrapper_start()
{
    echo '<section class="c-woocommerce"><div class="container">';
}

function io_wrapper_end()
{
    echo '</div></section>';
}


/*
 * Add theme support for Woocommerce
 */

add_action('after_setup_theme', 'woocommerce_support');

function woocommerce_support()
{
    add_theme_support('woocommerce');
}

/*
 * Add Excerpt to product overview page
 */

function add_excerpt_to_overview()
{
    $excerpt = get_the_excerpt();
    echo '<span class="short-description">' . wp_trim_words($excerpt, 10) . '</span>';
}

add_action('woocommerce_after_shop_loop_item_title', 'add_excerpt_to_overview', 40);


/*
 * Remove default Woocommerce stylesheet
 */

add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/*
 * Uncheck ship to different address
 */

add_filter('woocommerce_ship_to_different_address_checked', '__return_false');

/*
 * Enabling support for WooCommerce jQuery Slider
 */

add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-slider');


/*
 * Remove Woocommerce breadcrumbs
 */

add_action('init', 'woo_remove_wc_breadcrumbs');
function woo_remove_wc_breadcrumbs()
{
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
}
