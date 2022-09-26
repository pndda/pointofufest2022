<header class="c-header py-2 py-lg-4">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <a href="<?= get_home_url(); ?>" class="c-logo" title="Home"><?= get_bloginfo('name'); ?></a>
            </div>
            <div class="col-auto">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <nav role="navigation" class="c-nav-primary">
                            <?php wp_nav_menu(array('container' => 'ul', 'menu_class' => false, 'theme_location' => 'primary_navigation')); ?>
                        </nav>
                        <div class="c-hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <?php include 'partials/language-selector.php'; ?>
                </div>
            </div>

        </div>
    </div>
</header>
<div class="headerHeight"></div>
