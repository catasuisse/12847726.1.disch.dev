<!doctype html>
<html lang="de">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <?php
        if(class_exists('rex_yrewrite_seo')) {
            $seo = new rex_yrewrite_seo();

            echo $seo->getTitleTag().PHP_EOL;
            echo $seo->getDescriptionTag().PHP_EOL;
            echo $seo->getRobotsTag().PHP_EOL;
            echo $seo->getHreflangTags().PHP_EOL;
            echo $seo->getCanonicalUrlTag().PHP_EOL;
        }
        ?>

        <meta property="fb:app_id" content="966242223397117">

        <?php
        if(class_exists('rex_yrewrite_seo')) {
            ?>

            <meta property="og:title" content="<?php echo $seo->getTitle(); ?>" />
            <meta property="og:description" content="<?php echo $seo->getDescription(); ?>">
            <meta property="og:url" content="<?php echo $seo->getCanonicalUrl(); ?>">

            <?php
        }

        /*
        if($this->getValue('art_open_graph_image')) {
            ?>

            <meta property="og:image" content="<?php echo rex::getServer(); ?>media/<?php echo $this->getValue('art_open_graph_image'); ?>?v=<?php echo date('YmdHi', filemtime(rex_path::base('media/' . $this->getValue('art_open_graph_image')))); ?>">

            <?php
        }
        */
        ?>

        <meta property="og:type" content="website">

        <link rel="apple-touch-icon" sizes="180x180" href="/theme/public/assets/frontend/old/images/favicon/apple-touch-icon.png?v=<?php echo date('YmdHi', filemtime(rex_path::base('theme/public/assets/frontend/old/images/favicon/apple-touch-icon.png'))); ?>" />
        <link rel="icon" type="image/png" sizes="32x32" href="/theme/public/assets/frontend/old/images/favicon/favicon-32x32.png?v=<?php echo date('YmdHi', filemtime(rex_path::base('theme/public/assets/frontend/old/images/favicon/favicon-32x32.png'))); ?>" />
        <link rel="icon" type="image/png" sizes="16x16" href="/theme/public/assets/frontend/old/images/favicon/favicon/favicon-16x16.png?v=<?php echo date('YmdHi', filemtime(rex_path::base('theme/public/assets/frontend/old/images/favicon/favicon-16x16.png'))); ?>" />
        <link rel="manifest" href="/theme/public/assets/frontend/old/images/favicon/site.webmanifest?v=<?php echo date('YmdHi', filemtime(rex_path::base('theme/public/assets/frontend/old/images/favicon/site.webmanifest'))); ?>" />
        <link rel="mask-icon" href="/theme/public/assets/frontend/old/images/favicon/safari-pinned-tab.svg?v=<?php echo date('YmdHi', filemtime(rex_path::base('theme/public/assets/frontend/old/images/favicon/safari-pinned-tab.svg'))); ?>" color="#a78bfa" />
        <meta name="msapplication-TileColor" content="#a78bfa" />
        <meta name="theme-color" content="#ffffff" />

        <link rel="preconnect" href="//hello.myfonts.net/count/41789e" media="screen" />
        <link rel="stylesheet" href="/theme/public/assets/frontend/old/css/frontend.css?v=<?php echo date('YmdHi', filemtime(rex_path::base('theme/public/assets/frontend/old/css/frontend.css'))); ?>" />
    </head>

    <body class="dd-template-single" ontouchstart="">
        <div class="dd-main-wrapper">
            <main>
                <div class="dd-reading-progress-bar"></div>

                <?php echo $this->getArticle(); ?>

                <footer>
                    <div class="dd-container">
                        <a class="dd-d-flex" href="<?php echo rex_getUrl(1); ?>">
                            <svg class="dd-logo-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100" fill="currentColor">
                            	<title>Logo von Disch Development</title>

                            	<path class="dd-part-0" d="M100,50.003815L78.757324,71.246498l-0.000008-0.000008c-4.147926-4.147926-4.147926-10.873047,0-15.020973
                            		l6.221695-6.221703L71.246834,36.271633l7.51049-7.510492L100,50.003815z M0,50.003819l21.24268-21.242678l0.000008,0.000008
                            		c4.147926,4.147928,4.147926,10.873045,0,15.020971l-6.221701,6.221699L28.753168,63.736l-7.510492,7.510498L0,50.003819z
                            		 M67.224876,72.180267c-5.722382-1.182205-11.310627,2.528053-12.450089,8.259277l-1.210224,6.087952
                            		c0.698723,0.138565,1.395962,0.206375,2.082878,0.206375c4.963234,0,9.400211-3.498001,10.405537-8.55262l1.194-5.996559
                            		C67.246979,72.184692,67.239609,72.18322,67.224876,72.180267z" />
                                <path d="M80.795929,30.799744l-2.491684,12.529278l-7.057442-7.057446l7.510468-7.510475L80.795929,30.799744z" style="
                                    fill: #000000;
                                    opacity: .1;
                                " />
                            	<path class="dd-part-1" d="M66.435432,21.817457L64.00724,34.024822c-2.684952-2.359566-6.002499-4.071146-9.751064-4.837284
                            		c-11.511066-2.352652-22.798714,5.144688-25.09079,16.667969c-2.288752,11.506561,5.183876,22.690109,16.690441,24.978905
                            		c3.794411,0.754753,7.554729,0.448364,10.971859-0.715546c6.944374-2.363091,12.473248-8.263535,14.00713-15.97488
                            		l8.090111-40.67173l-0.000008-0.000002C73.171577,12.327843,67.579842,16.064117,66.435432,21.817457z M47.840057,60.399193
                            		c-5.646458-1.171688-9.350697-6.711948-8.275578-12.377586c1.107502-5.836296,6.781296-9.62923,12.597958-8.420918
                            		c5.646778,1.173019,9.349831,6.715061,8.272583,12.38089C59.325756,57.815826,53.654655,61.605774,47.840057,60.399193z" />
                            </svg>
                        </a>
                    </div>
                </footer>
            </main>
        </div>

        <div id="dd-cursor-shape" class="dd-cursor-shape"></div>

        <script type="text/javascript" src="/theme/public/assets/frontend/old/js/frontend.js?v=<?php echo date('YmdHi', filemtime(rex_path::base('theme/public/assets/frontend/old/js/frontend.js'))); ?>"></script>
    </body>
</html>
