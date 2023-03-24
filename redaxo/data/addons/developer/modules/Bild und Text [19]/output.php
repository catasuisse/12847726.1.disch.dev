<section class="dd-section-image-text dd-min-h-0<?= 'REX_VALUE[2]' == '1' ? ' dd-right-aligned' : null; ?>" data-scroll-section>
    <div class="dd-container-fluid" data-scroll>
        <div class="dd-row">
            <div class="dd-col-6">
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
            </div>
            <div class="dd-col-6">
                <div class="dd-content">
                    REX_VALUE[id=1 output=html]

                    <a class="dd-btn" href="javascript:;">
                        <span>Lorem ipsum</span>

                        <span>Lorem ipsum</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
