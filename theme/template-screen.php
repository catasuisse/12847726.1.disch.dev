<!doctype html>
<html lang="de">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="stylesheet" href="/theme/public/assets/frontend/old/css/frontend.css?v=<?php echo date('YmdHi', filemtime(rex_path::base('theme/public/assets/frontend/old/css/frontend.css'))); ?>" />
    </head>

    <body class="dd-template-screen" ontouchstart="">
        <div class="dd-main-wrapper">
            <main>
                <div id="dd-screen" class="dd-screen">
                    <div class="dd-ratio dd-ratio-16x9">
                        <video
                        autoplay
                        class="lazy video-js"
                        controls
                        data-setup='{}'
                        loop
                        muted
                        preload="none"
                        >
                            <source data-src="./theme/public/assets/frontend/new/videos/screen-202201280501-1280.webm" type="video/webm" />
                            <source data-src="./theme/public/assets/frontend/new/videos/screen-202201280501-1280.mp4" type="video/mp4" />
                        </video>
                    </div>
                </div>

                <script type="text/javascript">
                    document.addEventListener('DOMContentLoaded', function(event) {
                        $(function() {
                            setTimeout(function() {
                                location.reload();
                            }, 86400 * 1000);

                            // $(window).resize(function() {
                            //     var video = $('#dd-screen');
                            //
                            //     video.css({
                            //         'height': '',
                            //         'width': '',
                            //     });
                            //
                            //     if($(window).height() > video.height()) {
                            //         video.css({
                            //             'height': $(window).height() + 'px',
                            //             'width': $(window).height() / 9 * 16 + 'px',
                            //         });
                            //     }
                            // })
                            // .resize();
                        });
                    });
                </script>
            </main>
        </div>

        <script type="text/javascript" src="/theme/public/assets/frontend/old/js/frontend.js?v=<?php echo date('YmdHi', filemtime(rex_path::base('theme/public/assets/frontend/old/js/frontend.js'))); ?>"></script>
    </body>
</html>
