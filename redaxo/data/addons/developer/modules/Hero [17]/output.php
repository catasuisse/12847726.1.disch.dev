<section class="dd-section-hero" data-scroll-section>
    <div data-scroll>
        <?php
        if('REX_MEDIA[1]') {
            $imageTitle = rex_media::get('REX_MEDIA[1]');
            $imageTitle = !is_null($imageTitle) ? $imageTitle->getTitle() : null;
            ?>

            <div class="dd-image-wrapper">
                <img class="lazy" src="/media/REX_MEDIA[1]" alt="<?php echo $imageTitle; ?>" />
            </div>

            <?php
        }
        ?>
        
        <div class="dd-content">
            REX_VALUE[id=1 output=html]
        </div>
    </div>
</section>