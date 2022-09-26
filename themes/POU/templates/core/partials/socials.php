<?php
/**
 * @var $socials
 */
$facebook  = $socials['facebook'];
$linkedin  = $socials['linkedin'];
$instagram = $socials['instagram'];
?>
<?php if($facebook || $instagram || $linkedin): ?>
<ul class="c-socials list-unstyled">
    <?php if($facebook): ?>
    <li>
        <a href="<?= $facebook; ?>" target="_blank" class="c-socials__facebook">
            <svg><use href="#icon-facebook"></use></svg>
        </a>
    </li>
    <?php endif; ?>
    <?php if($instagram): ?>
        <li>
            <a href="<?= $instagram; ?>" target="_blank" class="c-socials__instagram">
                <svg><use href="#icon-instagram"></use></svg>
            </a>
        </li>
    <?php endif; ?>
    <?php if($linkedin): ?>
    <li>
        <a href="<?= $linkedin; ?>" target="_blank" class="c-socials__linkedin">
            <svg><use href="#icon-linkedin"></use></svg>
        </a>
    </li>
    <?php endif; ?>
</ul>
<?php endif; ?>
