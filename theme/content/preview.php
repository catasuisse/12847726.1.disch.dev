<?php
if(!rex_get('email') || !rex_get('url')) {
    dischdev()->redirect(6);
}
?>

<section data-scroll-section>
    <div class="dd-container" data-scroll data-scroll-position="top">
        <p class="dd-display-1 dd-text-gradient"><?php echo rex_get('url'); ?></p>

        <ul class="dd-call-to-actions">
            <?php echo '<li>' . dd_part()->callToAction(
                'Kontakt',
                'mailto:' . rex_get('email'),
            ) . '</li>'; ?>
        </ul>
    </div>
</section>
