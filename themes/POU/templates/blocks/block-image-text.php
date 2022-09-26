<?php
/**
 * @var $spacer (calculated in includes/spacing.php)
 */
$spacer_top    = get_field( 'block_imagetext_spacing_top' );
$spacer_bottom = get_field( 'block_imagetext_spacing_bottom' );
include "partials/spacing.php";

// Content
$title       = get_field('block_imagetext_title');
$text        = get_field('block_imagetext_text');
$image       = get_field('block_imagetext_image');
$link        = get_field('block_imagetext_link');
$button_type = get_field('block_imagetext_button_type');

// Options
$image_align = get_field('block_imagetext_align');

$image = wp_get_attachment_image($image['ID'], 'large', false, array("title" => get_the_title($image['ID']), 'class' => 'img-fluid'));
?>
<section class="b-block b-image-text<?= $spacer; ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-5<?php if($image_align === 'right'): ?> order-lg-last<?php endif; ?>">
                <?php if($link): ?>
                    <a href="<?= $link['url']; ?>" target="<?= $link['target']; ?>">
                <?php endif; ?>
                        <figure>
                            <?= $image; ?>
                        </figure>
                <?php if($link): ?>
                    </a>
            <?php endif; ?>
            </div>
            <div class="col-lg-7<?php if($image_align === 'right'): ?> order-lg-first<?php endif; ?>">
                <?php if ($title): ?>
                    <h2><?= $title; ?></h2>
                <?php endif; ?>
                <?php if ($text): ?>
                    <?= $text; ?>
                <?php endif; ?>
                <?php if ($link): ?>
                    <a href="<?= $link['url']; ?>" class="btn btn-<?= $button_type; ?>" target="<?= $link['target']; ?>">
                        <?= $link['title']; ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
