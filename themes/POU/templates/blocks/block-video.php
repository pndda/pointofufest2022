<?php
/**
 * @var $spacer (calculated in includes/spacing.php)
 */
$spacer_top    = get_field('block_video_spacing_top');
$spacer_bottom = get_field('block_video_spacing_bottom');
include "partials/spacing.php";

// Content
$url       = get_field('block_video_url');
$thumbnail = get_field('block_video_thumbnail');

// Thumbnail
// If thumbnail is set:
if ($thumbnail) {
    $thumbnail = wp_get_attachment_image($thumbnail['ID'], 'large', false, array("title" => get_the_title($thumbnail['ID']), 'class' => 'img-fluid'));
} // Else get it from their respective hosts
else {
    $thumbnail = '<img src="' . io_get_thumbnail($url) . '" class="img-fluid" width="1280" height="720">';
}
?>
<section class="b-block b-video<?= $spacer; ?>">
    <div class="container">
        <a class="b-video__play venobox" data-autoplay="true" data-vbtype="video" href="<?= $url; ?>">
            <?= $thumbnail; ?>
            <svg><use href="#icon-play"></use></svg>
        </a>
    </div>
</section>
