<?php
/**
 * Remove GF default styling
 */
add_filter('pre_option_rg_gforms_disable_css', '__return_true');

/**
 * Add hidden label option Gravity Forms
 */
add_filter('gform_enable_field_label_visibility_settings', '__return_true');

/**
 * Place GF Jquery in footer
 */
add_filter('gform_init_scripts_footer', '__return_true');

/**
 * Gravity forms: enable scroll to anchor
 */
add_filter('gform_confirmation_anchor', '__return_true');

/**
 * Change default currency to EUR
 * Afterwards disable the dropdown
 */
add_filter( 'gform_currency', 'gf_eur_currency' );
function gf_eur_currency( $currency ): string
{
    return 'EUR';
}
