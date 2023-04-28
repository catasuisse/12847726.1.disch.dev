<!doctype html>
<html lang="<?php echo rex_clang::getCurrent()->getCode(); ?>">
    <?php require_once('partials/head.php'); ?>

    <body class="dd-loading-state-1 dd-loading-state-2 -dd-scroll-t-05 dd-template-single">
        <div class="dd-main-wrapper">
            <main data-scroll-container>
                <?php
                require_once('partials/nav.php');

                echo $this->getArticle();
                
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
