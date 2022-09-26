<?php
/**
 * Polylang Language Selector
 */
if(function_exists('pll_current_language')):
    // Only show language selector if current post has more than 1 translation.
    $number_of_translations = pll_get_post_translations(get_the_ID());
if(count($number_of_translations) > 1): ?>
<div class="c-language-selector c-language-selector--mobile">
    <ul class="c-language-selector__list list-unstyled m-0">
        <?php pll_the_languages( array('display_names_as' => 'name', 'hide_if_no_translation' => 0, 'hide_current' => 1)); ?>
    </ul>
</div>
<?php endif; endif; ?>
<?php
/**
 * WPML Language Selector
 */
if(has_action('wpml_add_language_selector')):
    $translations = null;
    // Get current posts language information
    $args = array('element_id' => get_the_ID(), 'element_type' => 'post');
    $current_language_info = apply_filters('wpml_element_language_details', null, $args);

    // Get all available translations
    if($current_language_info){
        $translations = apply_filters('wpml_get_element_translations', '', $current_language_info->trid, 'post');
        // Remove current language from translations
        unset($translations[$current_language_info->language_code]);
    }
?>
    <div class="c-language-selector">
        <div class="c-language-selector__dropdown">
            <div class="c-language-selector__current">
                <span><?= apply_filters( 'wpml_current_language', NULL ); ?></span>
                <svg><use href="#icon-arrow-down"></use></svg>
            </div>
            <ul class="c-language-selector__list">
                <?php if($translations):
                    foreach($translations as $translation):
                        $language_code = $translation->language_code;
                        $url = apply_filters( 'wpml_permalink', get_permalink($translation->element_id), $language_code );
                ?>
                    <li class="lang-item"><a lang="<?= $language_code; ?>" hreflang= "<?= $language_code; ?>" href="<?= $url; ?>"><?= $language_code; ?></a></li>
                <?php endforeach; endif; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
