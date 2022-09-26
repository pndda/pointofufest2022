<?php
/**
 * @var $spacer (calculated in includes/spacing.php)
 */
$spacer_top    = get_field( 'block_gallery_spacing_top' );
$spacer_bottom = get_field( 'block_gallery_spacing_bottom' );
include "partials/spacing.php";

// Content
$title   = get_field('block_gallery_title');
$gallery = get_field('block_gallery_gallery');
?>
<section class="b-block b-gallery<?= $spacer; ?>">
    <div class="container">
        <?php if ($title): ?>
            <h2><?= $title; ?></h2>
        <?php endif; ?>
        <?php if($gallery): ?>
            <div class="row">
                <?php foreach ($gallery as $gallery_item):
                    $image = wp_get_attachment_image($gallery_item['ID'], 'medium', false, array("title" => get_the_title($gallery_item['ID']), 'class' => 'img-fluid'));
                    $url = $gallery_item['url'];
                    $caption = $gallery_item['caption'];
                ?>
                    <div class="col-lg-4 mb-2 mb-lg-4">
                        <a href="<?= $url; ?>" class="b-gallery__item venobox" data-gall="venobox">
                            <figure>
                                <?= $image ?>
                                <?php if ($caption !== ''): ?>
                                    <figcaption class="text-dark"><?= $caption; ?></figcaption>
                                <?php endif; ?>
                            </figure>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
