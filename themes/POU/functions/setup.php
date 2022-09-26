<?php
/**
 * Theme Setup
 */

add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary_navigation' => 'Primary Navigation',
        'legal_navigation' => 'Legal Navigation'
    ]);
    add_theme_support('post-thumbnails');
    add_post_type_support('page', 'excerpt');
    remove_theme_support('core-block-patterns');
});

/**
 * iO Login Logo
 */
function my_login_logo_url()
{
    return 'https://iodigital.com';
}
add_filter('login_headerurl', 'my_login_logo_url');
function my_login_logo_url_title()
{
    return 'Visit iodigital.com';
}
add_filter('login_headertext', 'my_login_logo_url_title');
