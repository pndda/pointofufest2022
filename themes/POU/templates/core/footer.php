<?php
$socials = get_field('socials', 'option');
?>
<footer class="c-footer py-2 py-lg-4">
    <div class="container">
        <?php if($socials): ?>
        <div class="row">
            <div class="col-auto">
                <?php include 'partials/socials.php'; ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="row justify-content-between">
            <div class="col-auto">
                <span>&copy; <?= date('Y'); ?> <?php bloginfo('name'); ?></span>
            </div>
            <div class="col-auto">
                <nav role="navigation" class="c-nav-legal">
                    <?php wp_nav_menu(array('container' => 'ul', 'menu_class' => false, 'theme_location' => 'legal_navigation')); ?>
                </nav>
            </div>
        </div>
    </div>
</footer>
