<div id="dd-logo-nav-wrapper" class="dd-logo-nav-wrapper">
    <?php
    echo '<a href="';

    if(
        $this->getTemplateId() == 1 ||
        $this->getTemplateId() == 7
    ) {
        $siteStartArticle = rex_article::getSiteStartArticle();

        echo 'javascript:;" data-target="#';

        if($siteStartArticle->getValue('art_anchor')) {
            echo $siteStartArticle->getValue('art_anchor');
        } else {
            echo 'dd-article-' . str_pad($siteStartArticle->getId(), 6, 0, STR_PAD_LEFT);
        }
    } else {
        echo rex_getUrl(1);
    }

    echo '">';

    echo dd_part()->logo();

    echo '</a>';
    ?>
</div>
