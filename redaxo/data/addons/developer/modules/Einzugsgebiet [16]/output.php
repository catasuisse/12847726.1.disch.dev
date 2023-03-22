<?php
if(rex::isFrontend()) {
    ?>

    <section id="dd-section-catchments" class="dd-min-h-0 dd-section-catchments" data-scroll-section>
        <div class="dd-container">
            <?php echo dd_part()->catchments(true, 'lg'); ?>
        </div>
    </section>

    <?php
}
?>
