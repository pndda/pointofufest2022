<?php
/**
 * @var $spacer (calculated in includes/spacing.php)
 */
$spacer_top    = get_field( 'block_flex_spacing_top' );
$spacer_bottom = get_field( 'block_flex_spacing_bottom' );
include "partials/spacing.php";

// Content
$title    = get_field('block_flex_title');
$repeater = get_field('block_flex_repeater');

// Options
$columns = get_field('block_flex_column_number');
?>
<section class="b-block b-flex<?= $spacer; ?>">
    <div class="container">
        <?php if ($title): ?>
            <h2><?= $title; ?></h2>
        <?php endif; ?>
        <?php if($repeater): ?>
            <div class="row">
                <?php foreach ($repeater as $column):
                    $col_class = match ($columns) {
                        '3' => 'col-sm-12 col-lg-4 mb-4',
                        '4' => 'col-sm-12 col-lg-6 col-xl-3 mb-4',
                        default => 'col-sm-12 col-lg-6 mb-4',
                    };
                    $title = $column['title'];
                    $text = $column['text'];
                    $link = $column['link'];
                    $button_type = $column['button_type'];
                    $image = wp_get_attachment_image($column['image']['ID'], 'medium', false, array("title" => get_the_title($column['image']['ID']), 'class' => 'img-fluid'));
                ?>
                    <div class="<?= $col_class; ?>">
                        <?php if($image): ?>
                            <?php if ($link): ?>
                            <a href="<?= $link['url']; ?>" target="<?= $link['target']; ?>">
                            <?php endif; ?>
                                <?= $image ?>
                            <?php if ($link): ?>
                            </a>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($title): ?>
                            <h3><?= $title; ?></h3>
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
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
