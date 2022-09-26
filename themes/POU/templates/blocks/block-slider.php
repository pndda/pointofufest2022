<?php
/**
 * @var $spacer (calculated in includes/spacing.php)
 */
$spacer_top    = get_field('block_slider_spacing_top');
$spacer_bottom = get_field('block_slider_spacing_bottom');
include "partials/spacing.php";

// Content
$title  = get_field('block_slider_title');
$images = get_field('block_slider_gallery');
?>
<section class="b-block b-slider<?= $spacer; ?>">
    <div class="container">
        <?php if ($title): ?>
            <h2><?= $title; ?></h2>
        <?php endif; ?>
        <?php if ($images): ?>
            <div class="b-slider__slider-wrapper">
                <button class="b-slider__button b-slider__button--prev">
                    <svg><use href="#icon-arrow-right"></use></svg>
                </button>
                <div class="b-slider__slider">
                    <?php foreach ($images as $image_arr):
                        $image = wp_get_attachment_image($image_arr['ID'], 'large', false, array('class' => 'img-fluid'));
                        ?>
                        <div class="c-slide">
                            <?= $image; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="b-slider__button b-slider__button--next">
                    <svg><use href="#icon-arrow-right"></use></svg>
                </button>
            </div>
        <?php endif; ?>
    </div>
</section>
