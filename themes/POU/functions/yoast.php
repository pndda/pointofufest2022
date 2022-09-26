<?php

/*
 * Add custom icon as breadcrumb separator
 */

function filter_wpseo_breadcrumb_separator($this_options_breadcrumbs_sep)
{
    return '<svg enable-background="new 0 0 15 26" height="26px" id="Layer_1" version="1.1" viewBox="0 0 15 26" width="15px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon fill="currentColor" points="2.019,0.58 -0.035,2.634 10.646,13.316 -0.035,23.997 2.019,26.052 14.755,13.316 "/></svg>';
}

;
add_filter('wpseo_breadcrumb_separator', 'filter_wpseo_breadcrumb_separator', 10, 100);

/*
 * Add custom item to breadcrumbs nav
 */

// add_filter( 'wpseo_breadcrumb_links', 'yoast_custom_breadcrumb_item' );

function yoast_custom_breadcrumb_item($links)
{
    global $post;

    // if is taxonomy or single custom post
    if (is_tax() || is_singular()) {
        $breadcrumb[] = array(
            'url' => get_permalink(),
            'text' => __('Breadcrumb name', 'io'),
        );

        array_splice($links, 1, -2, $breadcrumb);
    }

    return $links;
}
