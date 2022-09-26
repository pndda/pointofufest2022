<?php
/**
 * @var $spacer_top
 * @var $spacer_bottom
 */
$spacer_top_class    = $spacer_top ? 'pt-4 pt-md-5 pt-lg-6 pt-xl-7' : '';
$spacer_bottom_class = $spacer_bottom ? 'pb-4 pb-md-5 pb-lg-6 pb-xl-7' : '';
$spacer              = null;

if ( $spacer_top_class && $spacer_bottom_class ) {
    $spacer = ' ' . $spacer_top_class . ' ' . $spacer_bottom_class;
} elseif ( $spacer_top_class ) {
    $spacer = ' ' . $spacer_top_class;
} elseif ( $spacer_bottom_class ) {
    $spacer = ' ' . $spacer_bottom_class;
}
