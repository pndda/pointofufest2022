<?php
/**
 * ACF Sync command
 * Adapted from htdocs/content/plugins/acf_pro/includes/admin/admin-field-groups.php
 */
class ACF_Command
{
    function sync($args, $assoc_args)
    {
        $sync = array();
        if ( acf_get_local_json_files() ) {

            // Get all groups in a single cached query to check if sync is available.
            $all_field_groups = acf_get_field_groups();
            if(empty($all_field_groups)){
                return WP_CLI::success('Nothing to synchronize.');
            }
            foreach ( $all_field_groups as $field_group ) {
                // Extract vars.
                $local    = acf_maybe_get( $field_group, 'local' );
                $modified = acf_maybe_get( $field_group, 'modified' );
                $private  = acf_maybe_get( $field_group, 'private' );

                // Ignore if is private.
                if ( $private ) {
                    continue;

                    // Ignore not local "json".
                } elseif ( $local !== 'json' ) {
                    continue;

                    // Append to sync if not yet in database.
                } elseif ( ! $field_group['ID'] ) {
                    $sync[ $field_group['key'] ] = $field_group;

                    // Append to sync if "json" modified time is newer than database.
                } elseif ( $modified && $modified > get_post_modified_time( 'U', true, $field_group['ID'] ) ) {
                    $sync[ $field_group['key'] ] = $field_group;
                }
            }
        }

        if ( $sync ) {
            // Disabled "Local JSON" controller to prevent the .json file from being modified during import.
            acf_update_setting( 'json', false );

            // Sync field groups and generate array of new IDs.
            $files   = acf_get_local_json_files();
            foreach ( $sync as $key => $field_group ) {
                if ( $field_group['key'] ) {
                    // Import.
                } elseif ( $field_group['ID'] ) {
                    // Import.
                } else {
                    // Ignore.
                    continue;
                }
                $local_field_group       = json_decode( file_get_contents( $files[ $key ] ), true );
                $local_field_group['ID'] = $field_group['ID'];
                $result                  = acf_import_field_group( $local_field_group );
            }

            WP_CLI::success('ACF Fields have been succesfully synchronized.');
            exit;
        }
    }
}
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('acf', 'ACF_Command');
}

/**
 * ACF Options pages
 */
$site_name = get_bloginfo('name') . ' Settings';

if (function_exists('acf_add_options_page')) {
    $option_page = acf_add_options_page(array(
        'page_title' => 'Theme Settings',
        'menu_title' => $site_name,
        'menu_slug' => 'theme-settings',
        'capability' => 'edit_posts',
        'redirect' => false,
        'icon_url' => 'dashicons-layout',
    ));
}

/**
 * Translate ACF Options pages
 */
if(function_exists('pll_default_language')){
    function io_acf_settings_default_language($language)
    {
        return pll_default_language("slug");
    }
    function io_acf_settings_current_language($language)
    {
        return pll_current_language("slug");
    }
    add_filter('acf/settings/default_language', 'io_acf_settings_default_language');
    add_filter('acf/settings/current_language', 'io_acf_settings_current_language');
}

/**
 * Set default ACF values
 */
function set_default_true_false_value($field)
{
    $field['ui'] = true;
    return $field;
}

add_filter('acf/load_field/type=select', 'set_default_true_false_value');
add_filter('acf/load_field/type=true_false', 'set_default_true_false_value');

/**
 * Populate ACF select field options with Gravity Forms forms
 */
function acf_populate_gf_forms_ids($field)
{
    if (class_exists('GFFormsModel')) {
        $choices = [];
        foreach (\GFFormsModel::get_forms() as $form) {
            $choices[$form->id] = $form->title;
        }
        $field['choices'] = $choices;
    }
    return $field;
}

add_filter('acf/load_field/name=block_forms_form', 'acf_populate_gf_forms_ids');

/**
 * Set ACF wysiwyg media fields to 0
 */
function acf_set_media_upload_wysiwyg_false( $field ) {
    if($field['type'] == 'wysiwyg') {
        $field['media_upload'] = 0;
    }
    return $field;
}
add_filter('acf/get_valid_field', 'acf_set_media_upload_wysiwyg_false');
