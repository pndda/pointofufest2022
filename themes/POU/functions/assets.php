<?php
/**
 * Proper way to enqueue scripts and styles to keep the footer clean
 * Added cacheBuster to assets. Forces browser to download new assets when updates are applied (based on modification date of file)
 */
function styles_and_scripts()
{
    // Include CSS file to header with cache buster
    $cacheBuster = filemtime(get_template_directory() . '/build/css/main.css');
    wp_enqueue_style('main.css', get_template_directory_uri() . '/build/css/main.css', array(), $cacheBuster, null);

    // Remove default jQuery (to remove it from header)
    wp_deregister_script('jquery');

    // Include default jQuery (and put it in footer)
    wp_register_script('jquery', includes_url('/js/jquery/jquery.min.js'));
    wp_enqueue_script('jquery', '', '', '', true);

    // Remove Gutenberg blocks CSS
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style'); // Remove WooCommerce block CSS

    // Include main.js file to footer with cache buster
    $cacheBuster = filemtime(get_template_directory() . '/build/js/main.js');
    wp_enqueue_script('scripts.js', get_template_directory_uri() . '/build/js/main.js', array(), $cacheBuster, true);

    // Include js-cookie from vendor folder
    wp_enqueue_script('js-cookie', get_stylesheet_directory_uri() . '/build/js/vendor/js.cookie.min.js', array(), null, true);

    // Add php vars to scripts.js => vars['ajaxurl']
    $vars = array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'templateurl' => get_stylesheet_directory_uri(),
        'siteurl' => get_site_url()
    );
    wp_localize_script('scripts.js', 'vars', $vars);

    // Fix touchstart warning on Google Pagespeed Insights
    wp_add_inline_script('jquery', 'jQuery.event.special.touchstart = {
        setup: function( _, ns, handle ) {
            this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
        }
    };
    jQuery.event.special.touchmove = {
        setup: function( _, ns, handle ) {
            this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
        }
    };
    jQuery.event.special.wheel = {
        setup: function( _, ns, handle ){
            this.addEventListener("wheel", handle, { passive: true });
        }
    };
    jQuery.event.special.mousewheel = {
        setup: function( _, ns, handle ){
            this.addEventListener("mousewheel", handle, { passive: true });
        }
    };');
}

add_action('wp_enqueue_scripts', 'styles_and_scripts');


/**
 * Include Backend / Gutenberg styling scripts
 */
function io_add_gutenberg_to_admin()
{
    wp_register_style('io_gutenberg_css', get_stylesheet_directory_uri() . '/build/css/gutenberg.css', false, '1.0.0');
    wp_enqueue_style('io_gutenberg_css');
}
add_action('enqueue_block_editor_assets', 'io_add_gutenberg_to_admin');
