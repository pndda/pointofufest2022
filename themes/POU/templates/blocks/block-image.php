<?php
/**
 * @var $spacer (calculated in includes/spacing.php)
 */
$spacer_top    = get_field( 'block_image_spacing_top' );
$spacer_bottom = get_field( 'block_image_spacing_bottom' );
include "partials/spacing.php";

// Content
$image   = get_field('block_image_image');
$caption = get_field('block_image_caption');
$image   = wp_get_attachment_image($image['ID'], 'large', false, array("title" => get_the_title($image['ID']), 'class' => 'img-fluid'));
?>
<section class="b-block b-image<?= $spacer; ?>">
    <div class="container">
        <?php if($image): ?>
            <figure>
                <?= $image; ?>
                <?php if ($caption != ''): ?>
                    <figcaption><?= $caption; ?></figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>
    </div>
</section>
