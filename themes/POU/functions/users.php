<?php

/*
 * Create Io User role
 */

$capabilities =array(
    "create_posts" => true,
    "create_users" => true,
    "delete_others_pages" => true,
    "delete_others_posts" => true,
    "delete_pages" => true,
    "delete_posts" => true,
    "delete_private_pages" => true,
    "delete_private_posts" => true,
    "delete_published_pages" => true,
    "delete_published_posts" => true,
    "edit_files" => true,
    "edit_others_pages" => true,
    "edit_others_posts" => true,
    "edit_pages" => true,
    "edit_posts" => true,
    "edit_private_pages" => true,
    "edit_private_posts" => true,
    "edit_published_pages" => true,
    "edit_published_posts" => true,
    "edit_users" => true,
    "gravityforms_api_settings" => false,
    "gravityforms_create_form" => true,
    "gravityforms_delete_entries" => true,
    "gravityforms_delete_forms" => true,
    "gravityforms_edit_entries" => true,
    "gravityforms_edit_entry_notes" => true,
    "gravityforms_edit_forms" => true,
    "gravityforms_edit_settings" => false,
    "gravityforms_export_entries" => true,
    "gravityforms_preview_forms" => true,
    "gravityforms_view_entries" => true,
    "gravityforms_view_entry_notes" => true,
    "level_0" => true,
    "level_1" => true,
    "level_10" => true,
    "level_2" => true,
    "level_3" => true,
    "level_4" => true,
    "level_5" => true,
    "level_6" => true,
    "level_7" => true,
    "level_8" => true,
    "level_9" => true,
    "list_users" => true,
    "loco_admin" => true,
    "manage_categories" => true,
    "moderate_comments" => false,
    "promote_users" => true,
    "publish_pages" => true,
    "publish_posts" => true,
    "read" => true,
    "read_private_pages" => true,
    "read_private_posts" => true,
    "unfiltered_html" => false,
    "unfiltered_upload" => true,
    "upload_files" => true,
    "edit_theme_options" => true,
    "redirection_cap_redirect_manage" => true,
    "redirection_cap_redirect_add" => true,
    "redirection_cap_redirect_delete" => true,
    "manage_links" => true,
    "restrict_content" => true,
    "manage_options" => false,
    "delete_users" => true,
    "view_woocommerce_reports" => true,
    "manage_woocommerce" => true,
    "activate_plugins" => false,
    "assign_product_terms" => true,
    "assign_shop_coupon_terms" => true,
    "assign_shop_order_terms" => true,
    "create_roles" => false,
    "delete_others_products" => true,
    "delete_others_shop_coupons" => true,
    "delete_others_shop_orders" => true,
    "delete_plugins" => false,
    "delete_private_products" => true,
    "delete_private_shop_coupons" => true,
    "delete_private_shop_orders" => true,
    "delete_product" => true,
    "delete_product_terms" => true,
    "delete_products" => true,
    "delete_published_products" => true,
    "delete_published_shop_coupons" => true,
    "delete_published_shop_orders" => true,
    "delete_roles" => false,
    "delete_shop_coupon" => true,
    "delete_shop_coupon_terms" => true,
    "delete_shop_coupons" => true,
    "delete_shop_order" => true,
    "delete_shop_order_terms" => true,
    "delete_shop_orders" => true,
    "delete_themes" => false,
    "edit_dashboard" => false,
    "edit_others_products" => true,
    "edit_others_shop_coupons" => true,
    "edit_others_shop_orders" => true,
    "edit_plugins" => false,
    "edit_private_products" => true,
    "edit_private_shop_coupons" => true,
    "edit_private_shop_orders" => true,
    "edit_product" => true,
    "edit_product_terms" => true,
    "edit_products" => true,
    "edit_published_products" => true,
    "edit_published_shop_coupons" => true,
    "edit_published_shop_orders" => true,
    "edit_roles" => false,
    "edit_shop_coupon" => true,
    "edit_shop_coupon_terms" => true,
    "edit_shop_coupons" => true,
    "edit_shop_order" => true,
    "edit_shop_order_terms" => true,
    "edit_shop_orders" => true,
    "edit_themes" => false,
    "export" => false,
    "import" => false,
    "install_plugins" => false,
    "install_themes" => false,
    "list_roles" => false,
    "manage_product_terms" => true,
    "manage_shop_coupon_terms" => true,
    "manage_shop_order_terms" => true,
    "publish_products" => true,
    "publish_shop_coupons" => true,
    "publish_shop_orders" => true,
    "read_private_products" => true,
    "read_private_shop_coupons" => true,
    "read_private_shop_orders" => true,
    "read_product" => true,
    "read_shop_coupon" => true,
    "read_shop_order" => true,
    "remove_users" => true,
    "switch_themes" => false,
    "update_core" => false,
    "update_plugins" => false,
    "update_themes" => false,
    "view_site_health_checks" => false,
    "delete_blocks" => false,
    "publish_blocks" => false,
    "read_private_blocks" => false,
    "delete_private_blocks" => false,
    "edit_private_blocks" => false
);

// Add new role
add_role('io', __('Io User', 'io'), $capabilities);

// Set new user role to default
add_filter('pre_option_default_role', 'io_set_default_user_role');

function io_set_default_user_role(){
    return 'io';
};

// Remove default roles
remove_role('subscriber');
remove_role('contributor');
remove_role('author');
remove_role('translator');
remove_role('editor');
remove_role('wpseo_editor');
remove_role('wpseo_manager');


/*
 * Add Custom link to site-menus to sidebar - only for Io
 */

add_action('admin_menu', 'add_menu_url');
function add_menu_url() {
    $user = wp_get_current_user();
    $roles_arr = $user->roles;

    if (in_array('io', $roles_arr)) {
        add_menu_page('Menus', 'Menus', 'read', admin_url() . '/nav-menus.php', '', 'dashicons-admin-links', 75);
    }
}

/*
 * Limit backend for Io User
 */

add_action('admin_menu', 'remove_menus');
function remove_menus() {
    $user = wp_get_current_user();
    if(in_array('io', $user->roles)) {
        $restrictions = array(
            '/wp-admin/widgets.php',
            '/wp-admin/upgrade-functions.php',
            '/wp-admin/edit.php?post_type=acf-field-group',
            '/wp-admin/post-new.php?post_type=acf-field-group',
            '/wp-admin/themes.php',
            '/wp-admin/options-general.php',
            '/wp-admin/options-writing.php',
            '/wp-admin/options-reading.php',
            '/wp-admin/options-media.php',
            '/wp-admin/options-permalink.php',
            '/wp-admin/options-privacy.php',
            '/wp-admin/export-personal-data.php',
            '/wp-admin/erase-personal-data.php',
            '/wp-admin/tools.php?page=action-scheduler',
            '/wp-admin/theme-editor.php',
            '/wp-admin/network.php',
            '/wp-admin/ms-users.php',
            '/wp-admin/ms-upgrade-network.php',
            '/wp-admin/ms-themes.php',
            '/wp-admin/ms-sites.php',
            '/wp-admin/ms-options.php',
            '/wp-admin/ms-edit.php',
            '/wp-admin/ms-delete-site.php',
            '/wp-admin/ms-admin.php',
            '/wp-admin/moderation.php',
            '/wp-admin/edit-link-form.php',
            '/wp-admin/edit-comments.php',
            '/wp-admin/credits.php',
            '/wp-admin/about.php',
            '/wp-admin/customize.php',
        );

        foreach ($restrictions as $restriction) {
            if (!current_user_can('manage_network') && $_SERVER['REQUEST_URI'] == $restriction) {
                wp_redirect(admin_url());
                exit;
            }
        }

        // Remove menu's
        remove_menu_page('plugins.php');
        remove_menu_page('themes.php');
        remove_menu_page('options-general.php');
        remove_menu_page('edit.php?post_type=acf-field-group');
        remove_menu_page('mlang');
        remove_menu_page('tools.php');

        // Remove some submenu's
        remove_submenu_page('tools.php', 'export-personal-data.php');
        remove_submenu_page('tools.php', 'erase-personal-data.php');
        remove_submenu_page( 'tools.php', 'action-scheduler' );
        remove_submenu_page('gf_edit_forms', 'gf_help');
        remove_submenu_page('loco', 'loco-lang');
        remove_submenu_page('loco', 'loco-core');
        remove_submenu_page('loco', 'loco-config');
        remove_submenu_page('loco', 'loco-config-user');
    }
}


/*
 * Limit top admin bar
 */

add_action('admin_bar_menu', 'remove_toolbar_nodes', 999);
function remove_toolbar_nodes($wp_admin_bar) {
    $wp_admin_bar->remove_node('wp-logo');
    $wp_admin_bar->remove_node('updates');
    $wp_admin_bar->remove_node('new-content');
    $wp_admin_bar->remove_node('new-post');
    $wp_admin_bar->remove_node('new-media');
    $wp_admin_bar->remove_node('new-page');
    $wp_admin_bar->remove_node('new-blogs');
    $wp_admin_bar->remove_node('new-user');
    $wp_admin_bar->remove_node('wpseo-menu');
    $wp_admin_bar->remove_node('wpfc-toolbar');
    $wp_admin_bar->remove_node('customize');
    $wp_admin_bar->remove_node('search');
}

/**
 * WHEN io-USER gets access to user management, prevent him from editing/adding/removing existing/new admins!
 */

// Helper function
function io_role_is_admin() {
    //Get current user & check its role
    $user = wp_get_current_user();
    return ( in_array('administrator', $user->roles) );
}

// Remove all admins from users list when listing all users
function io_edit_users_list( $args ){
    if( !io_role_is_admin() ){
        $args['role__not_in'] = 'Administrator';
    }

    return $args;
}

add_filter('users_list_table_query_args', 'io_edit_users_list');

//Removing admin view from list/will be empty anyways
function io_edit_users_views( $views ) {
    if( !io_role_is_admin() ){
        unset( $views['administrator'] );
    }

    return $views;
}
add_filter('views_users', 'io_edit_users_views');

// Remove administrator from all user-roles lists when user is not admin
function io_edit_user_roles( $roles ) {
    if( !io_role_is_admin() ){
        unset( $roles['administrator'] );
    }

    return $roles;
}
add_filter('editable_roles', 'io_edit_user_roles');

// Prevent io-user of viewing edit-user.php for admin-id's
function io_check_user_has_right_to_edit_user() {
    global $pagenow;

    if( $pagenow == 'user-edit.php' ){
        $user_id = wp_get_current_user()->ID;
        $edit_user_id = filter_var( $_GET['user_id'] );

        if( $user_id != $edit_user_id) { //If not your own page!
            $user_meta=get_userdata($edit_user_id);
            $user_roles=$user_meta->roles;

            if( !io_role_is_admin() && in_array( 'administrator', $user_roles ) ){
                wp_die( __( 'Sorry, you are not allowed to edit this user.' ) );
            }
        }
    }
}
add_action('wp_loaded', 'io_check_user_has_right_to_edit_user');
