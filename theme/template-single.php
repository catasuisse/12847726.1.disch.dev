<?php
$navIsHidden = false;

if(class_exists('Url\Url') && Url\Url::resolveCurrent()) {
    $manager = Url\Url::resolveCurrent();

    $post = rex_yform_manager_table::get('dd_post')
        ->query()
        ->findId($manager->getDatasetId());

    $visitedPosts = explode(',', rex_session('visited_posts'));

    if($post->getValue('exhibit') && !in_array($post->getValue('id'), $visitedPosts)) {
        $navIsHidden = true;
    }

    rex_set_session('visited_posts', dischdev()->addToList($post->getValue('id'), rex_session('visited_posts')));
}
?>

<!doctype html>
<html lang="<?php echo rex_clang::getCurrent()->getCode(); ?>">
    <?php require_once('partials/head.php'); ?>

    <body class="dd-loading-state-1 dd-loading-state-2 -dd-scroll-t-05 dd-template-single<?php echo $navIsHidden ? ' dd-nav-is-hidden' : null; ?>">
        <div class="dd-main-wrapper">
            <main data-scroll-container>
                <?php /*
                <div id="dd-main-background" class="dd-main-background" data-scroll-section>
                    <?php echo dd_part()->picture(
                        'theme/public/assets/frontend/new/images/background-main',
                        null
                    ); ?>
                </div>
                */ ?>

                <?php
                require_once('partials/nav.php');

                if(dischdev()->permission($this->getArticleId())) {
                    echo $this->getArticle();
                } else {
                    dd_part()->tokenForm($this->getArticleId());
                }
                
                require_once('partials/footer.php');
                require_once('partials/logo.php');
                require_once('partials/misc.php');
                ?>
            </main>
        </div>

        <?php
        require_once('partials/scripts.php');
        ?>
    </body>
</html>
