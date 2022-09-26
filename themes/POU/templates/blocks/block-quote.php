<?php
/**
 * @var $spacer (calculated in includes/spacing.php)
 */
$spacer_top    = get_field('block_quote_spacing_top');
$spacer_bottom = get_field('block_quote_spacing_bottom');
include "partials/spacing.php";

// Content
$quote  = get_field('block_quote_quote');
$author = get_field('block_quote_author');
?>
<?php if ($quote): ?>
    <section class="b-block b-quote<?= $spacer; ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <figure>
                        <blockquote>
                            <?= $quote; ?>
                        </blockquote>
                        <?php if ($author): ?>
                            <figcaption><?= $author ?></figcaption>
                        <?php endif; ?>
                    </figure>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
