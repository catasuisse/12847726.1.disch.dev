<?php
$landing = dd_post()->landing();
$visitedPosts = explode(',', rex_session('visited_posts'));

if($landing && !in_array($landing['id'], $visitedPosts)) {
    dischdev()->redirect('', '', ['post_id' => $landing['id']]);
}
?>

<!doctype html>
<html lang="<?php echo rex_clang::getCurrent()->getCode(); ?>">
    <?php
    require_once('partials/head.php');
    ?>

    <body class="dd-loading-state-1 dd-loading-state-2 -dd-scroll-t-05 dd-template-default">
        <div class="dd-main-wrapper">
            <main data-scroll-container>
                <?php
                $siteStartArticle = rex_article::getSiteStartArticle();

                echo '<div id="';

                if($siteStartArticle->getValue('art_anchor')) {
                    echo $siteStartArticle->getValue('art_anchor');
                } else {
                    echo 'dd-article-' . str_pad($siteStartArticle->getId(), 6, 0, STR_PAD_LEFT);
                }

                echo '" class="dd-article" data-scroll-section></div>';

                require_once('partials/intro.php');
                require_once('partials/nav.php');
                require_once('partials/header.php');

                echo (new rex_article_content($siteStartArticle->getId()))->getArticle();

                $value = [];

                foreach(rex_category::getRootCategories(true) as $value[0]) {
                    if($value[0]->getValue('cat_single')) {
                        continue;
                    }

                    foreach($value[0]->getArticles(true) as $value[1]) {
                        // if($value[1]->getId() == 24) {
                        //     continue;
                        // }

                        echo '<div id="';

                        if($value[1]->getValue('art_anchor')) {
                            echo $value[1]->getValue('art_anchor');
                        } else {
                            echo 'dd-article-' . str_pad($value[1]->getId(), 6, 0, STR_PAD_LEFT);
                        }

                        echo '" class="dd-article" data-scroll-section></div>';

                        echo (new rex_article_content($value[1]->getId()))->getArticle();
                    }
                }

                echo '<div id="kontakt" class="dd-article" data-scroll-section></div>';
                
                require_once('content/contact.php');
                require_once('content/about-me.php');
                require_once('partials/copyright.php');
                require_once('partials/footer.php');
                require_once('partials/logo.php');
                require_once('partials/address.php');
                require_once('partials/misc.php');
                ?>
            </main>
        </div>

        <?php
        require_once('partials/scripts.php');
        ?>
    </body>
</html>
