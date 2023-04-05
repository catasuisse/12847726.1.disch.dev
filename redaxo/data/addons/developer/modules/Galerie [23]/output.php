<?php
if(rex::isFrontend()) {
    $images = explode(',', 'REX_MEDIALIST[1]');

    if($images) {
        ?>

        <section class="dd-section-gallery dd-py-0" data-scroll-section>
            <div class="dd-exhibits" data-visible-items="3">
                <?php
                foreach($images as $value) {
                    $imageTitle = rex_media::get($value);
                    $imageTitle = isset($imageTitle) ? $imageTitle->getTitle() : null;
                ?>

                <a class="dd-exhibit" href="<?php echo rex_media_manager::getUrl('dd_original_2400', $value); ?>" data-fancybox="dd-image" data-scroll>
                    <figure>
                        <picture>
                            <source
                                data-srcset="
                                    <?php echo rex_media_manager::getUrl('dd_16x9_800', $value); ?> 800w,
                                    <?php echo rex_media_manager::getUrl('dd_16x9_1600', $value); ?> 1600w,
                                    <?php echo rex_media_manager::getUrl('dd_16x9_2400', $value); ?> 2400w
                                "
                                sizes="100vw"
                                type="image/jpg"
                                />

                            <img
                                data-srcset="
                                <?php echo rex_media_manager::getUrl('dd_16x9_800', $value); ?> 800w,
                                <?php echo rex_media_manager::getUrl('dd_16x9_1600', $value); ?> 1600w,
                                <?php echo rex_media_manager::getUrl('dd_16x9_2400', $value); ?> 2400w
                                "
                                data-src="<?php echo rex_media_manager::getUrl('dd_16x9_1600', $value); ?>"
                                alt="<?php echo $imageTitle; ?>"
                                title="<?php echo $imageTitle; ?>"
                                class="lazy"
                                />
                        </picture>
                    </figure>
                </a>

                <?php
                }
                ?>
            </div>
        </section>

        <?php
    }
} else {
    ?>

    <div style="background-image: repeating-linear-gradient(45deg, #fff, #fff 10px, #dfe3e9 10px, #dfe3e9 20px); height: 180px; margin: -15px; opacity: .5;"></div>

    <?php
}
?>
