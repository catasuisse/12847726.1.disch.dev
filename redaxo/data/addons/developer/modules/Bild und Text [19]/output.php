<?php
$button = 'REX_LINK[1]';
$label = 'REX_VALUE[3]';
?>

<section class="dd-section-image-text dd-min-h-0<?= 'REX_VALUE[2]' == '1' ? ' dd-right-aligned' : null; ?>" data-scroll-section>
    <div class="dd-container dd-container-lg-fluid" data-scroll>
        <div class="dd-row dd-row-expanded">
            <div class="dd-col-12 dd-col-lg-6">
                <?php
                if('REX_MEDIA[1]') {
                    $imageTitle = rex_media::get('REX_MEDIA[1]');
                    $imageTitle = !is_null($imageTitle) ? $imageTitle->getTitle() : null;
                    ?>

                    <a class="dd-image-wrapper" href="<?php echo rex_media_manager::getUrl('dd_original_2400', 'REX_MEDIA[1]'); ?>" data-fancybox="dd-image">
                        <img class="lazy" src="/media/REX_MEDIA[1]" alt="<?php echo $imageTitle; ?>" />
                    </a>

                    <?php
                }
                ?>
            </div>
            <div class="dd-col-12 dd-col-lg-6">
                <div class="dd-content">
                    REX_VALUE[id=1 output=html]

                    <?php
                    if($button) {
                        $article = rex_article::get($button);
                        
                        echo $article ? '<a class="dd-btn" href="' . rex_getUrl($button) . '"><span>' . ($label ? $label : $article->getName()) . '</span><span>' . ($label ? $label : $article->getName()) . '</span></a>' : null;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
