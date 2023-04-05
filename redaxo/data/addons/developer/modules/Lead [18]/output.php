<?php
$button = 'REX_LINK[1]';
$label = 'REX_VALUE[2]';
?>

<section class="dd-min-h-0 dd-section-lead" data-scroll-section>
    <div class="dd-container" data-scroll>
        REX_VALUE[id=1 output=html]

        <?php
        if($button) {
            $article = rex_article::get($button);
            
            echo $article ? '<a class="dd-btn" href="' . rex_getUrl($button) . '"><span>' . ($label ? $label : $article->getName()) . '</span><span>' . ($label ? $label : $article->getName()) . '</span></a>' : null;
        }
        ?>
    </div>
</section>
