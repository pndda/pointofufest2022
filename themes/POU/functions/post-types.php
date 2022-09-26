<?php
/**
 * Remove default WP Posttype
 */

function remove_default_post_type() {
    remove_menu_page('edit.php');
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
}
add_action( 'admin_menu', 'remove_default_post_type' );

/**
 * Register CPT Products
 */
function io_add_cpt_products()
{
    $labels = array(
        'name' => 'Products',
        'singular_name' => 'Product',
        'menu_name' => 'Products',
        'name_admin_bar' => 'Products',
        'archives' => 'Product Archives',
        'attributes' => 'Product Attributes',
        'parent_item_colon' => 'Parent Product:',
        'all_items' => 'All Products',
        'add_new_item' => 'Add New Product',
        'add_new' => 'Add New',
        'new_item' => 'New Product',
        'edit_item' => 'Edit Product',
        'update_item' => 'Update Product',
        'view_item' => 'View Product',
        'view_items' => 'View Products',
        'search_items' => 'Search Product',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'featured_image' => 'Featured Image',
        'set_featured_image' => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image' => 'Use as featured image',
        'insert_into_item' => 'Insert into Product',
        'uploaded_to_this_item' => 'Uploaded to this Product',
        'items_list' => 'Products list',
        'items_list_navigation' => 'Products list navigation',
        'filter_items_list' => 'Filter Products list',
    );
    $args = array(
        'label' => 'Product',
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
        'show_in_rest' => true,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 50,
        'menu_icon' => 'dashicons-image-filter',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
        'rewrite' => array('with_front' => false, 'slug' => 'products'),
    );
    register_post_type('cpt-products', $args);
}
//add_action('init', 'io_add_cpt_products', 0);

/**
 * Register TAX Kind
 */

function io_add_tax_kind()
{
    register_taxonomy(
        'tax-products-kind',
        'cpt-products',
        array(
            'label' => 'Kind',
            'hierarchical' => true,
            'show_in_rest' => true, // Needed for tax to appear in Gutenberg editor.
            'rewrite' => array(
                'slug' => 'kind',
                'with_front' => false
            ),
        )
    );
}
//add_action('init', 'io_add_tax_kind');

/**
 * Fix for custom post-type/taxonomies + paging
 */
function add_cpt_rewrites()
{
    $tax_objs = array(); // Will capture all CPT slugs
    $regexLangUrls = '('; // Empty regex for language-based urls
    $languages = pll_languages_list(); // Grabbing the languages
    $regexTax = '/([^/]+)'; // Regex part to capture taxonomy
    $regexPaging = '/page(?:/([0-9]+))'; // Regex part for capturing paging
    $regexTrailingSlash = '?/?$'; // Regex trailing slash

    // Grab all custom registered taxonomies that are publicly available!
    $tax_list = get_taxonomies(array(
        '_builtin' => false,
        'public' => true,
    ));

    foreach ($tax_list as $tax_name) {
        $tax = get_taxonomy($tax_name);
        array_push($tax_objs, array(
            'slug' => $tax->rewrite['slug'],
            'name' => $tax->name
        ));
    }

    /** Create first part of regex : language slugs **/
    // Looping over languages in polylang
    foreach ($languages as $index => $lang) {
        $regexLangUrls .= ($index > 0) ? '|' : '';
        $regexLangUrls .= $lang;
    }
    $regexLangUrls .= ')/';

    /** Create second part of regex : cpt-slug/name **/
    // Looping over all taxonomies to create rules per posttype/taxonomy
    foreach ($tax_objs as $tax) {
        $translated_slugs = array();
        foreach ($languages as $index => $lang) {
            array_push($translated_slugs, pll_translate_string($tax['slug'], $lang));
        }

        // Capture cpt name
        $regexUrl = '(';
        foreach ($translated_slugs as $index => $string) {
            $regexUrl .= ($index > 0) ? '|' : '';
            $regexUrl .= $string;
        }
        $regexUrl .= ')';

        // Rules without taxonomy but with paging
        add_rewrite_rule($regexLangUrls . $regexUrl . $regexPaging . $regexTrailingSlash, 'index.php?lang=$matches[1]&pagename=$matches[2]&paged=$matches[3]', 'top');
        add_rewrite_rule($regexUrl . $regexPaging . $regexTrailingSlash, 'index.php?pagename=$matches[1]&paged=$matches[2]', 'top');

        // Rules without paging but with taxonomy
        add_rewrite_rule($regexLangUrls . $regexUrl . $regexTax . $regexTrailingSlash, 'index.php?lang=$matches[1]&pagename=$matches[2]&' . $tax['name'] . '=$matches[3]', 'top');
        add_rewrite_rule($regexUrl . $regexTax . $regexTrailingSlash, 'index.php?pagename=$matches[1]&' . $tax['name'] . '=$matches[2]', 'top');

        // Rules with taxonomy & paginag
        add_rewrite_rule($regexLangUrls . $regexUrl . $regexTax . $regexPaging . $regexTrailingSlash, 'index.php?lang=$matches[1]&pagename=$matches[2]&' . $tax['name'] . '=$matches[3]&paged=$matches[4]', 'top');
        add_rewrite_rule($regexUrl . $regexTax . $regexPaging . $regexTrailingSlash, 'index.php?pagename=$matches[1]&' . $tax['name'] . '=$matches[2]&paged=$matches[3]', 'top');

        // Rules with taxonomy & paginag
        add_rewrite_rule($regexLangUrls . $regexUrl . $regexTax . $regexTrailingSlash, 'index.php?lang=$matches[1]&' . $tax['name'] . '=$matches[3]', 'top');
        add_rewrite_rule($regexUrl . $regexTax . $regexTrailingSlash, 'index.php?' . $tax['name'] . '=$matches[2]', 'top');
    }
    // Rewrite rule for paging on cpt's (without taxonomies!)
    add_rewrite_rule('(.?.+?)/page/?([0-9]{1,})/?$', 'index.php?pagename=$matches[1]&paged=$matches[2]', 'top');
}
// add_action('init', 'add_cpt_rewrites');
