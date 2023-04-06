<?php
/*
if($this->getArticleId() != 25 && !rex::getUser()) {
    dischdev()->redirect(6);
}
*/
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, width=device-width" />

    <?php
    if(class_exists('Url\Seo') && class_exists('Url\Url') && Url\Url::resolveCurrent()) {
        $manager = Url\Url::resolveCurrent();

        if($manager) {
            \rex_extension::register('URL_SEO_TAGS', function(\rex_extension_point $extensionPoint) use ($manager) {
                $tags = $extensionPoint->getSubject();

                $title = strip_tags($tags['title']);

                if($manager->getSeoTitle()) {
                    $title = $manager->getSeoTitle();
                }

                if(rex::getServerName()) {
                    $title .= ' / ' . rex::getServerName();
                }

                $tags['title'] = '<title>' . $title . '</title>';
                $tags['og:title'] = '<meta property="og:title" content="' . $title . '" />';
                $tags['og:image'] = null;
                $tags['twitter:title'] = '<meta name="twitter:title" content="' . $title . '" />';
                $tags['twitter:image'] = null;
                $tags['twitter:card'] = null;

                $extensionPoint->setSubject($tags);
            });
        }

        echo (new Url\Seo())->getTags();
    } else if(class_exists('rex_yrewrite_seo')) {
        echo dd_seo()->titleTag();
        echo dd_seo()->descriptionTag();
        echo (new rex_yrewrite_seo())->getCanonicalUrlTag() . PHP_EOL;
        echo (new rex_yrewrite_seo())->getRobotsTag() . PHP_EOL;
    	echo (new rex_yrewrite_seo())->getHreflangTags() . PHP_EOL;
        echo '<meta property="og:title" content="' . dd_seo()->title() . '" />' . PHP_EOL;
        echo '<meta property="og:description" content="' . dd_seo()->description() . '" />' . PHP_EOL;
        echo '<meta property="og:url" content="' . (new rex_yrewrite_seo())->getCanonicalUrl() . '" />' . PHP_EOL;
        echo '<meta name="twitter:title" content="' . dd_seo()->title() . '" />' . PHP_EOL;
        echo '<meta name="twitter:description" content="' . dd_seo()->description() . '" />' . PHP_EOL;
        echo '<meta name="twitter:url" content="' . (new rex_yrewrite_seo())->getCanonicalUrl() . '" />' . PHP_EOL;
    }

    echo '<meta property="fb:app_id" content="966242223397117" />' . PHP_EOL;
    // echo '<meta property="og:image" content="https://disch.dev/theme/public/assets/frontend/new/images/open-graph-image.png?v=' . filemtime('theme/public/assets/frontend/new/images/open-graph-image.png') . '" />' . PHP_EOL;
    // echo '<meta property="og:type" content="' . ($this->getTemplateId() == 1 ? 'website' : 'article') . '" />' . PHP_EOL;
    echo '<meta property="og:type" content="website" />' . PHP_EOL;
    // echo '<meta name="twitter:image" content="https://disch.dev/theme/public/assets/frontend/new/images/open-graph-image.png?v=' . filemtime('theme/public/assets/frontend/new/images/open-graph-image.png') . '" />' . PHP_EOL;
    echo '<meta name="twitter:card" content="summary_large_image" />' . PHP_EOL;
	?>

    <link rel="apple-touch-icon" href="/theme/public/assets/frontend/new/images/favicon/apple-touch-icon.png?v=<?php echo filemtime('theme/public/assets/frontend/new/images/favicon/apple-touch-icon.png'); ?>" sizes="180x180" />
    <link rel="icon" href="/theme/public/assets/frontend/new/images/favicon/favicon-32x32.png?v=<?php echo filemtime('theme/public/assets/frontend/new/images/favicon/favicon-32x32.png'); ?>" sizes="32x32" type="image/png" />
    <link rel="icon" href="/theme/public/assets/frontend/new/images/favicon/favicon-16x16.png?v=<?php echo filemtime('theme/public/assets/frontend/new/images/favicon/favicon-16x16.png'); ?>" sizes="16x16" type="image/png" />
    <link rel="manifest" href="/theme/public/assets/frontend/new/images/favicon/site.webmanifest?v=<?php echo filemtime('theme/public/assets/frontend/new/images/favicon/site.webmanifest'); ?>" />
    <link rel="mask-icon" href="/theme/public/assets/frontend/new/images/favicon/safari-pinned-tab.svg?v=<?php echo filemtime('theme/public/assets/frontend/new/images/favicon/safari-pinned-tab.svg'); ?>" color="#7156ee" />
    <meta name="msapplication-TileColor" content="#7156ee" />
    <meta name="theme-color" content="#000000" />

    <link rel="stylesheet" href="/theme/public/assets/frontend/new/css/frontend.css?v=<?php echo filemtime('theme/public/assets/frontend/new/css/frontend.css'); ?>" media="screen" />
</head>
