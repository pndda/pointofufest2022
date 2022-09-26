<!doctype html>
<html class="no-js" lang="<?php bloginfo('language'); ?>">
<head>
    <?php if (!defined('WPSEO_VERSION')): ?>
        <title><?php bloginfo('name'); ?></title>
        <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php endif; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="author" content="<?php bloginfo('name'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('stp-theme'); ?>>
<?php get_template_part('templates/core/header'); ?>
<main role="main">
    <?php include io_template_path(); ?>
</main>
<?php get_template_part('templates/core/footer'); ?>
<?php get_template_part('templates/core/sidebar'); ?>
<?php get_template_part('templates/includes/cookiebanner'); ?>
<?php wp_footer(); ?>
<div class="hidden" hidden>
    <?php include_once('build/sprite/sprite.svg'); ?>
</div>
</body>
</html>
