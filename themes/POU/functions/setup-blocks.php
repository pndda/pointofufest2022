<?php

/**
 * Gutenberg blocks setup
 */
$io_blocks = array(
    /**
     * io blocks
     */
    array(
        'name' => 'block-editor',
        'title' => 'Block Editor',
        'description' => 'A default editor block.',
        'category' => 'io-blocks',
        'icon' => 'edit',
        'enqueue_assets' => null,
    ),
    array(
        'name' => 'block-cta',
        'title' => 'Block CTA',
        'description' => 'A default cta block.',
        'category' => 'io-blocks',
        'icon' => 'megaphone',
        'enqueue_assets' => null,
    ),
    array(
        'name' => 'block-flex',
        'title' => 'Block Flexible columns',
        'description' => 'A default flexible columns block.',
        'category' => 'io-blocks',
        'icon' => 'columns',
        'enqueue_assets' => null,
    ),
    array(
        'name' => 'block-forms',
        'title' => 'Block Forms',
        'description' => 'A default forms block.',
        'category' => 'io-blocks',
        'icon' => 'forms',
        'enqueue_assets' => null,
    ),
    array(
        'name' => 'block-gallery',
        'title' => 'Block Gallery',
        'description' => 'A default gallery block.',
        'category' => 'io-blocks',
        'icon' => 'format-gallery',
        'enqueue_assets' => function(){
            wp_enqueue_script( 'venobox', get_template_directory_uri() . '/build/js/vendor/venobox.min.js', array('jquery'), '', true );
        },
    ),
    array(
        'name' => 'block-hero',
        'title' => 'Block Hero',
        'description' => 'A default hero block.',
        'category' => 'io-blocks',
        'icon' => 'align-full-width',
        'enqueue_assets' => null,
    ),
    array(
        'name' => 'block-image',
        'title' => 'Block Image',
        'description' => 'A default image block.',
        'category' => 'io-blocks',
        'icon' => 'format-image',
        'enqueue_assets' => null,
    ),
    array(
        'name' => 'block-image-text',
        'title' => 'Block Image Text',
        'description' => 'A default image text block.',
        'category' => 'io-blocks',
        'icon' => 'align-left',
        'enqueue_assets' => null,
    ),
    array(
        'name' => 'block-quote',
        'title' => 'Block Quote',
        'description' => 'A default quote block.',
        'category' => 'io-blocks',
        'icon' => 'format-quote',
        'enqueue_assets' => null,
    ),
    array(
        'name' => 'block-slider',
        'title' => 'Block Slider',
        'description' => 'A default slider block.',
        'category' => 'io-blocks',
        'icon' => 'slides',
        'enqueue_assets' => function(){
            wp_enqueue_script( 'slick-slider', get_template_directory_uri() . '/build/js/vendor/slick.min.js', array('jquery'), '', true );
        },
    ),
    array(
        'name' => 'block-video',
        'title' => 'Block Video',
        'description' => 'A default video block.',
        'category' => 'io-blocks',
        'icon' => 'format-video',
        'enqueue_assets' => function(){
            wp_enqueue_script( 'venobox', get_template_directory_uri() . '/build/js/vendor/venobox.min.js', array('jquery'), '', true );
        },
    ),
);
// Sort array $io_blocks by block name
usort($io_blocks, function($a, $b) {
    return $a['name'] <=> $b['name'];
});

/**
 * Create io blocks
 */
add_action('acf/init', 'io_acf_init');
function io_acf_init()
{
    if (function_exists('acf_register_block_type')) {
        global $io_blocks;
        if (is_array($io_blocks) || is_object($io_blocks)) {
            global $io_blocks;
            foreach ($io_blocks as $io_block) {
                acf_register_block_type(array(
                    'name' => $io_block['name'],
                    'title' => $io_block['title'],
                    'description' => $io_block['description'],
                    'keywords' => explode(' ', $io_block['description']),
                    'category' => $io_block['category'],
                    'render_callback' => 'io_block_render_callback',
                    'icon' => $io_block['icon'],
                    'mode' => 'edit',
                    'supports' => array('align' => false),
                    'enqueue_assets' => $io_block['enqueue_assets'],
                ));
            }
        }
    }
}

/**
 * Create io block-category
 */
add_filter('block_categories', 'io_block_categories', 10, 2);
function io_block_categories($categories, $post)
{
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'io-blocks',
                'title' => 'io Blocks',
            ),
        )
    );
}

/**
 * Create io block render callback
 */
function io_block_render_callback($block)
{
    $name = str_replace('acf/', '', $block['name']);
    if (file_exists(get_theme_file_path("/templates/blocks/{$name}.php"))) {
        include(get_theme_file_path("/templates/blocks/{$name}.php"));
    }
}

/**
 * Enable only io-blocks
 */
add_filter('allowed_block_types', 'allow_block_types');
function allow_block_types($allowed_block_types)
{
    $allowed_block_types = array();
    global $io_blocks;
    foreach ($io_blocks as $io_block) {
        array_push($allowed_block_types, 'acf/' . $io_block['name']);
    }

    return $allowed_block_types;
}
