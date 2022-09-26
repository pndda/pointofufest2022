<?php
/**
 * @var $spacer (calculated in includes/spacing.php)
 */
$spacer_top    = get_field( 'block_editor_spacing_top' );
$spacer_bottom = get_field( 'block_editor_spacing_bottom' );
include "partials/spacing.php";

// Content
$title = get_field('block_editor_title');
$text  = get_field('block_editor_text');

// Options
$align = get_field('block_editor_text_align');
?>
<section class="b-block b-editor text-<?= $align; ?><?= $spacer; ?>">
    <div class="container">
        <?php if ($title): ?>
            <h2><?= $title; ?></h2>
        <?php endif; ?>
        <?php if ($text): ?>
            <?= $text; ?>
        <?php endif; ?>
    </div>
</section>
