<?php

class dd_part
{
    public static function archive($posts)
    {
        ?>

        <section class="dd-min-h-0" data-scroll-section>
            <div class="dd-container" data-scroll>
                <ul class="dd-h-consistent dd-list-archive dd-list-hero">
                    <?php
                    foreach($posts as $value) {
                        echo '

                            <li>
                                <a href="' . rex_getUrl('', '', ['post_id' => $value['id']]) . '">
                                    <h3 class="dd-mb-0">' . $value['title'] . '</h3>

                                    <p class="dd-metadata">' . dd::metadata(strtotime($value['createdate'])) . '</p>
                                </a>
                            </li>

                        ';
                    }
                    ?>
                </ul>
            </div>
        </section>

        <?php
    }

    public static function background($image = null, $opacity = null, $grayscale = null)
    {
        $image = $image ? $image : 'background-202303161309';
        ?>

        <div class="dd-background-wrapper">
            <div class="dd-background">
                <div class="dd-figure-wrapper">
                    <figure>
                        <picture style="
                            <?php echo $grayscale ? 'filter: grayscale(' . $grayscale . ');' : null; ?>
                        ">
                            <source
                            data-srcset="
                                /theme/public/assets/frontend/new/images/<?php echo $image; ?>-2400.webp 2400w,
                                /theme/public/assets/frontend/new/images/<?php echo $image; ?>-3200.webp 3200w,
                                /theme/public/assets/frontend/new/images/<?php echo $image; ?>-4000.webp 4000w
                            "
                            sizes="100vw"
                            type="image/webp"
                            />

                            <source
                            data-srcset="
                                /theme/public/assets/frontend/new/images/<?php echo $image; ?>-2400.jpg 2400w,
                                /theme/public/assets/frontend/new/images/<?php echo $image; ?>-3200.jpg 3200w,
                                /theme/public/assets/frontend/new/images/<?php echo $image; ?>-4000.jpg 4000w
                            "
                            sizes="100vw"
                            type="image/jpg"
                            />

                            <img
                            data-srcset="
                                /theme/public/assets/frontend/new/images/<?php echo $image; ?>-2400.jpg 2400w,
                                /theme/public/assets/frontend/new/images/<?php echo $image; ?>-3200.jpg 3200w,
                                /theme/public/assets/frontend/new/images/<?php echo $image; ?>-4000.jpg 4000w
                            "
                            data-src="/theme/public/assets/frontend/new/images/<?php echo $image; ?>-3200.jpg"
                            src="/theme/public/assets/frontend/new/images/<?php echo $image; ?>-4000.jpg"
                            class="lazy"
                            />
                        </picture>
                    </figure>
                </div>
            </div>

            <div class="dd-overlay dd-overlay-1"></div>
            <div class="dd-overlay dd-overlay-2" style="
                <?php echo $opacity ? 'background-color: rgba(0, 0, 0, ' . $opacity . ');' : null; ?>
                <?php echo $grayscale ? 'filter: grayscale(' . $grayscale . ');' : null; ?>
            "></div>
        </div>

        <?php
    }

    public static function backLink($articleId)
    {
        $backLink = [];

        if(!dd::internalRefferer() && $articleId == '24' && class_exists('Url\Url') && Url\Url::resolveCurrent()) {
            $backLink[] = rex_getUrl(24);
            $backLink[] = 'Start';
        } else if(dd::internalRefferer() && ($articleId != '24' || ($articleId == '24' && class_exists('Url\Url') && Url\Url::resolveCurrent()))) {
            $backLink[] = 'javascript:history.back()';
            $backLink[] = 'zurück';
        } else {
            $backLink[] = rex_getUrl(1);
            $backLink[] = 'Start';
        }

        return $backLink;
    }

    public static function callToAction($label, $href, $parameter = null, $class = null)
    {
        $callToAction  = '<a class="dd-with-arrow' . ($class ? ' ' . $class : null) . '" href="' . $href . '"' . ($parameter ? ' ' . $parameter : null) . '>';
        $callToAction .= '<span>' . $label . '</span>';
        $callToAction .= file_get_contents(rex_path::base('theme/public/assets/frontend/new/images/icon-arrow-' . (str_contains($class, 'dd-left-aligned') ? 'left' : 'right') . '.svg'));
        $callToAction .= '</a>';

        return $callToAction;
    }

    public static function catchments($links = false, $size = 'sm')
    {
        $catchments = [];
        $index = [];
        $keyword = null;
        $value = [];

        if($size == 'lg') {
            $catchments[0] = dd_data::catchments();

            $catchments[1] = '
            
                <div class="dd-row">
                    <div class="dd-col-12 dd-col-lg-4">
                        <ul class="dd-no-style">
            
            ';

            foreach($catchments[0] as $value) {
                $keyword = !$keyword ? $value['keyword'] : $keyword;
                
                $catchments[1] .= $keyword != $value['keyword'] ? '

                        </ul>
                    </div>
                    <div class="dd-col-12 dd-col-lg-4">
                        <ul class="dd-no-style">
                
                ' : null;

                $catchments[1] .= '<li>' . ($links ? '<a href="' . $value['url'] . '" title="' . $value['title'][3][0] . '">' : null) . $value['title'][2][0] . ($links ? '</a>' : null) . '</li>';

                $keyword = $keyword != $value['keyword'] ? $value['keyword'] : $keyword;
            }

            $catchments[1] .= '
                    
                        </ul>
                    </div>
                </div>
            
            ';
        } else {
            $catchments[0] = [
                'cities' => [
                    dd_data::catchment(61),
                    dd_data::catchment(54),
                    dd_data::catchment(65),
                    dd_data::catchment(53),
                    dd_data::catchment(68),
                ],

                'states' => [
                    dd_data::catchment(57),
                    dd_data::catchment(66),
                    dd_data::catchment(62),
                ],
            ];

            $catchments[1] = 'Agentur für Webdesign und SEO für ';

            $index[0] = 0;

            foreach($catchments[0]['cities'] as $value[0]) {
                if($index[0] == array_key_last($catchments[0]['cities'])) {
                    $catchments[1] .= ' und ';
                } else if($index[0] > 0) {
                    $catchments[1] .= ', ';
                }

                if($index[0] == array_key_last($catchments[0]['cities']) && $size == 'md') {
                    $catchments[1] .= ($links ? '<a href="' . rex_getUrl(34) . '" title="Einzugsgebiet von ' . rex::getServerName() . '">' : null) . 'weitere Gemeinden' . ($links ? '</a>' : null) . ' in ';

                    $index[1] = 0;

                    foreach($catchments[0]['states'] as $value[1]) {
                        if($index[1] == array_key_last($catchments[0]['states'])) {
                            $catchments[1] .= ' und ';
                        } else if($index[1] > 0) {
                            $catchments[1] .= ', ';
                        }

                        $catchments[1] .= ($links ? '<a href="' . $value[1]['url'] . '" title="' . $value[1]['title'][3][0] . '">' : null) . $value[1]['city']['name'] . ($links ? '</a>' : null);

                        $index[1]++;
                    }
                } else {
                    $catchments[1] .= ($links ? '<a href="' . $value[0]['url'] . '" title="' . $value[0]['title'][3][0] . '">' : null) . $value[0]['city']['name'] . ($links ? '</a>' : null);
                }

                $index[0]++;
            }
        }

        $catchments = $catchments[1];

        return $catchments;
    }

    public static function clock($class = null, $id = null, $label = false)
    {
        $timeZone = dd_data::timeZone();

        echo '

            <div' . ($id ? ' id="' . $id . '"' : null) . ' class="dd-clock' . ($class ? ' ' . $class : null) . '">
                <div class="dd-indicators">

        ';

        for($index = 0; $index < 60; $index++) {
            echo '

                    <div class="dd-indicator"></div>

            ';
        }

        echo '

                </div>
                ' . (dd_time::get(null, null, $timeZone['timezone']) != time() ? '<div class="dd-clock-label">' . $timeZone['country'] . '</div>' : null) . '
                <div class="dd-minute"></div>
                <div class="dd-hour"></div>
                <div class="dd-second"></div>
                <div class="dd-axis"></div>
            </div>

        ';
    }

    public static function commentForm($post, $token = null)
    {
        $token = dd::unformatedToken($token);
        ?>

        <section id="dd-section-comment-form" class="dd-min-h-0 dd-section-comment-form" data-scroll-section>
            <div class="dd-container" data-scroll>
                <h2 style="
                    margin-bottom: 4rem;
                ">Kommentar hinterlassen</h2>

                <ul class="dd-alerts" style="
                    margin-bottom: 4rem;
                "></ul>

                <form>
                    <?php
                    if(!$token) {
                        ?>

                        <div class="dd-form-row dd-form-row-rule">
                            <div class="dd-col-12 dd-col-lg-6">
                                <div class="dd-form-group">
                                    <label>Wie lautet deine E-Mail-Adresse?</label>

                                    <?php
                                    if(rex_addon::get('emailobfuscator')->isAvailable()) {
                                        emailobfuscator::whitelistEmail(rex_session('email'));
                                    }
                                    ?>

                                    <input name="email" type="email" value="<?php echo rex_session('email') ? rex_session('email') : null; ?>" autocomplete="off" />
                                    <div class="dd-alert">–</div>
                                </div>
                            </div>

                            <div class="dd-col-12 dd-col-lg-6">
                                <div class="dd-form-group">
                                    <label>Wie darf ich dich ansprechen?</label>
                                    <input name="callname" type="text" value="<?php echo rex_session('callname') ? rex_session('callname') : null; ?>" autocomplete="off" />
                                    <div class="dd-alert">–</div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    ?>

                    <div class="dd-form-row dd-form-row-rule">
                        <div class="dd-col-12">
                            <div class="dd-form-group">
                                <label>Was denkst du darüber?</label>
                                <textarea name="content" rows="<?php echo $token ? '9' : '6'; ?>" autocomplete="off"></textarea>
                                <div class="dd-alert">–</div>
                            </div>
                        </div>
                    </div>

                    <input name="parent" type="hidden" value="" autocomplete="off" />
                    <input name="honeypot" type="email" autocomplete="off" />
                    <input name="notification" type="hidden" value="<?php echo rex_session('notification') ? rex_session('notification') : '0'; ?>" autocomplete="off" />
                    <input name="post" type="hidden" value="<?php echo $post; ?>" autocomplete="off" />

                    <?php
                    if($token) {
                        ?>

                        <input name="token" type="hidden" value="<?php echo $token; ?>" autocomplete="off" />

                        <?php
                    }
                    ?>

                    <div class="dd-checkbox-wrapper<?php echo rex_session('notification') ? ' dd-active' : null; ?>" data-name="notification">
                        <div class="dd-checkbox"></div>
                        <label>Ich möchte per E-Mail benachrichtigt werden, wenn mir jemand antwortet.</label>
                    </div>

                    <ul class="dd-call-to-actions">
                        <?php echo '<li>' . self::callToAction(
                            'Senden',
                            'javascript:;',
                            'data-action="submit"'
                        ) . '</li>'; ?>
                    </ul>
                </form>
            </div>
        </section>

        <?php
    }

    public static function comments($post)
    {
        $comments = dd_data()->comments($post);
        ?>

        <section class="dd-space-less<?php echo !$comments ? ' dd-d-none' : null; ?>" data-scroll-section></section>

        <section id="dd-section-comments" class="dd-min-h-0 dd-section-comments<?php echo !$comments ? ' dd-d-none' : null; ?>" data-scroll-section>
            <div class="dd-container">
                <div id="dd-comments" class="dd-comments">
                    <?php
                    foreach($comments as $value) {
                        $callname = $value['callname'];

                        if(!$callname && $value['firstname'] && $value['lastname']) {
                            $callname = $value['firstname'] . ' ' . substr($value['lastname'], 0, 1);
                        }
                        ?>

                        <div id="dd-comment-<?php echo str_pad($value['id'], 6, 0, STR_PAD_LEFT); ?>" class="dd-comment dd-comment-depth-<?php echo $value['depth']; ?>" data-scroll>
                            <?php echo dd::paragraphs($value['content']); ?>

                            <p class="dd-metadata"><?php echo dd::metadata(strtotime($value['createdate']), $callname); ?></p>

                            <?php
                            // if($value['depth'] < 1) {
                            //     echo '<p class="dd-fs-xs">' . self::callToAction(
                            //         'Antworten',
                            //         'javascript:;',
                            //         'data-parent="' . $value['id'] . '"'
                            //     ) . '</p>';
                            // }
                            ?>
                        </div>

                        <?php
                    }
                    ?>
                </div>
            </div>
        </section>

        <?php
    }

    public static function contact()
    {
        ?>

        <div class="dd-container">
            <p class="dd-display-2 dd-display-lg-1" data-ajax-availability><?php echo self::loader(); ?></p>

            <ul class="dd-call-to-actions">
                <li data-ajax-meetings><?php echo self::loader(); ?></li>
            </ul>
        </div>

        <?php
    }

    public static function contactForm($header = null)
    {
        ?>

        <section id="dd-section-contact-form" class="dd-min-h-0 dd-section-contact-form" data-scroll-section>
            <div class="dd-container" data-scroll data-address>
                <?php echo $header; ?>
                
                <ul class="dd-alerts" style="
                    margin-bottom: 4rem;
                    <?php echo $header ? 'margin-top: 4rem;' : null; ?>
                "></ul>

                <form style="
                    <?php echo $header ? 'margin-top: 4rem;' : null; ?>
                ">
                    <div class="dd-form-row dd-form-row-rule">
                        <div class="dd-col-12">
                            <div class="dd-form-group">
                                <label>Was möchtest du mir erzählen?</label>
                                <textarea name="content" rows="6" autocomplete="off"></textarea>
                                <div class="dd-alert">–</div>
                            </div>
                        </div>
                    </div>

                    <div class="dd-form-row dd-form-row-rule">
                        <div class="dd-col-12 dd-col-lg-6">
                            <div class="dd-form-group">
                                <label>Wie lautet deine E-Mail-Adresse?</label>
                                <input name="email" type="email" autocomplete="off" />
                                <div class="dd-alert">–</div>
                            </div>
                        </div>

                        <div class="dd-col-12 dd-col-lg-6">
                            <div class="dd-form-group">
                                <label>Wie darf ich dich ansprechen?</label>
                                <input name="callname" type="text" autocomplete="off" />
                                <div class="dd-alert">–</div>
                            </div>
                        </div>
                    </div>

                    <input name="article" type="hidden" value="<?php echo rex_article::getCurrentId(); ?>" autocomplete="off" />
                    <input name="honeypot" type="email" autocomplete="off" />
                    <input name="referer" type="hidden" value="<?php echo array_key_exists('HTTP_REFERER', $_SERVER) && $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : null; ?>" autocomplete="off" />

                    <p class="dd-fs-xs" style="
                        margin-top: 2rem;
                    ">Ich nehme den Schutz persönlicher Daten sehr ernst und versuche, ihn auch technisch zu gewährleisten. Garantieren kann ich ihn technisch aber nicht, weil Angriffe durch Hacker immer möglich sind. Mehr dazu erfährst du in meiner <a href="<?php echo rex_getUrl(29); ?>">Datenschutzerklärung</a>.</p>

                    <ul class="dd-call-to-actions">
                        <?php echo '<li>' . dd_part::callToAction(
                            'Senden',
                            'javascript:;',
                            'data-action="submit"'
                        ) . '</li>'; ?>
                    </ul>
                </form>
            </div>
        </section>

        <?php
    }

    public static function homeLink($article = false)
    {
        $article = !$article ? rex_article::getCurrentId() : $article;
        $homeLink = false;

        if((!dd::internalRefferer() || dd::internalRefferer() == 'disch.xyz') && $article == '24' && class_exists('Url\Url') && Url\Url::resolveCurrent()) {
            $homeLink = rex_getUrl(24);
        } else {
            $homeLink = rex_getUrl(1);
        }

        return $homeLink;
    }

    public static function loader()
    {
        return '
            
            <span class="dd-text-accent dd-text-flash">_</span>
            
        ';
    }

    public static function logo($landscape = false, $background = true, $wordmark = false, $class = null)
    {
        static $index = 0;

        if($landscape && $wordmark) {
            $backgroundPosition = [-13.2662, 0];
            $height = 149.268356;
            $width = 289.960175;
        } else if($wordmark) {
            $backgroundPosition = [43.7777, 0];
            $height = 149.268356;
            $width = 187.559082;
        } else {
            $backgroundPosition = [0, 0];
            $height = 100;
            $width = 100;
        }
        ?>

        <svg
        class="dd-logo-<?php echo str_pad($index, 2, 0, STR_PAD_LEFT) . ($class ? ' ' . $class : null); ?> dd-logo"
        fill="currentColor"
        height="<?php echo $height; ?>"
        id="dd-logo-<?php echo str_pad($index, 2, 0, STR_PAD_LEFT); ?>"
        viewBox="0 0 <?php echo $width . ' ' . $height; ?>"
        width="<?php echo $width; ?>"
        xmlns="http://www.w3.org/2000/svg"
        >
            <title>Logo von Disch Development</title>
            
            <?php
            if($background) {
                ?>

                <g style="clip-path: url(#dd-logo-<?php echo str_pad($index, 2, 0, STR_PAD_LEFT); ?>-shape);">
                    <image
                    height="100"
                    width="100"
                    x="<?php echo $backgroundPosition[0]; ?>"
                    xlink:href="/theme/public/assets/frontend/new/images/background-logo-<?php echo $landscape && !$wordmark ? 'landscape' : 'portrait'; ?>.jpg"
                    y="<?php echo $backgroundPosition[1]; ?>"
                    ></image>
                </g>

                <?php
            }
            ?>

            <?php
            if($landscape) {
                if($wordmark) {
                    echo '
                    
                        <path class="dd-part-3" d="M132.135956,59.796955h1.4375v0.370605c0,0.943359,0.516602,1.257812,1.055664,1.257812 s1.021973-0.325684,1.021973-1.19043v-4.346191h-2.055176V54.64217h3.503906v5.615234 c0,1.740723-1.257812,2.493164-2.493164,2.493164c-1.224121,0-2.470703-0.774902-2.470703-2.493164V59.796955z M140.419647,54.64217 h4.772949v1.246582h-3.324219v2.088867h2.683594v1.246582h-2.683594v2.14502h3.503906v1.246582h-4.952637V54.64217z M148.276581,54.64217h2.716797c2.459961,0,4.066406,1.459961,4.066406,3.975586s-1.606445,3.998047-4.066406,3.998047h-2.716797 V54.64217z M150.915253,61.369221c1.617188,0,2.650391-0.95459,2.650391-2.751465c0-1.774414-1.055664-2.729004-2.650391-2.729004 h-1.19043v5.480469H150.915253z M157.973846,54.64217h4.772461v1.246582h-3.324219v2.088867h2.68457v1.246582h-2.68457v2.14502 h3.503906v1.246582h-4.952148V54.64217z M166.009003,60.571857c0,0,0.865234,0.842285,1.988281,0.842285 c0.606445,0,1.15625-0.314453,1.15625-0.96582c0-1.42627-3.761719-1.179199-3.761719-3.627441 c0-1.325195,1.145508-2.313477,2.672852-2.313477c1.572266,0,2.380859,0.853516,2.380859,0.853516l-0.628906,1.179199 c0,0-0.763672-0.696289-1.762695-0.696289c-0.673828,0-1.202148,0.393066-1.202148,0.95459 c0,1.415039,3.750977,1.066895,3.750977,3.616211c0,1.269043-0.96582,2.335938-2.62793,2.335938 c-1.774414,0-2.750977-1.089355-2.750977-1.089355L166.009003,60.571857z M177.581268,54.64217h3.076172 c1.494141,0,2.539062,1.044434,2.539062,2.594238s-1.044922,2.62793-2.539062,2.62793h-1.62793v2.751465h-1.448242V54.64217z M180.387909,58.606525c0.842773,0,1.336914-0.539062,1.336914-1.370117c0-0.819824-0.494141-1.347656-1.313477-1.347656h-1.381836 v2.717773H180.387909z M185.875214,54.64217h1.448242v7.973633h-1.448242V54.64217z M192.408417,58.572834l-2.380859-3.930664 h1.651367l1.088867,1.954102c0.258789,0.460449,0.504883,0.977051,0.504883,0.977051h0.023438 c0,0,0.224609-0.505371,0.482422-0.977051l1.111328-1.954102h1.662109l-2.402344,3.930664l2.492188,4.042969h-1.62793 l-1.235352-2.14502c-0.257812-0.460449-0.494141-0.943359-0.494141-0.943359h-0.022461c0,0-0.224609,0.48291-0.494141,0.943359 l-1.223633,2.14502h-1.617188L192.408417,58.572834z M199.253143,54.64217h4.773438v1.246582h-3.324219v2.088867h2.683594v1.246582 h-2.683594v2.14502h3.503906v1.246582h-4.953125V54.64217z M207.110565,54.64217h1.448242v6.727051h3.448242v1.246582h-4.896484 V54.64217z M218.872284,60.571857c0,0,0.865234,0.842285,1.988281,0.842285c0.606445,0,1.15625-0.314453,1.15625-0.96582 c0-1.42627-3.761719-1.179199-3.761719-3.627441c0-1.325195,1.145508-2.313477,2.672852-2.313477 c1.572266,0,2.380859,0.853516,2.380859,0.853516l-0.628906,1.179199c0,0-0.763672-0.696289-1.762695-0.696289 c-0.673828,0-1.202148,0.393066-1.202148,0.95459c0,1.415039,3.750977,1.066895,3.750977,3.616211 c0,1.269043-0.96582,2.335938-2.62793,2.335938c-1.774414,0-2.750977-1.089355-2.750977-1.089355L218.872284,60.571857z M226.31369,54.64217h1.449219v7.973633h-1.449219V54.64217z M232.835175,55.888752h-2.616211V54.64217h6.682617v1.246582h-2.617188 v6.727051h-1.449219V55.888752z M238.771698,61.683674l3.538086-5.076172c0.314453-0.460449,0.583984-0.71875,0.583984-0.71875 v-0.022461c0,0-0.224609,0.022461-0.595703,0.022461h-3.34668V54.64217h5.760742v0.920898l-3.537109,5.087402 c-0.314453,0.460449-0.583984,0.71875-0.583984,0.71875v0.022461c0,0,0.224609-0.022461,0.595703-0.022461h3.570312v1.246582 h-5.985352V61.683674z M249.300018,55.888752h-2.616211V54.64217h6.682617v1.246582h-2.617188v6.727051h-1.449219V55.888752z M254.94455,61.189533h1.426758v1.42627h-1.426758V61.189533z"/>
                        <path class="dd-part-2" d="M100.475792,34.724689h3.622559c3.27832,0,5.418457,1.945801,5.418457,5.298828 s-2.140137,5.329102-5.418457,5.329102h-3.622559V34.724689z M103.99337,43.690998c2.155762,0,3.532715-1.272461,3.532715-3.66748 c0-2.364746-1.407227-3.637207-3.532715-3.637207h-1.586426v7.304688H103.99337z M113.40255,34.724689h1.931152v10.62793h-1.931152 V34.724689z M120.13546,42.628498c0,0,1.152344,1.122559,2.649414,1.122559c0.808105,0,1.541504-0.419434,1.541504-1.287598 c0-1.900879-5.014648-1.571777-5.014648-4.834961c0-1.766113,1.526855-3.083496,3.562988-3.083496 c2.095703,0,3.17334,1.137695,3.17334,1.137695l-0.838379,1.571777c0,0-1.018066-0.928223-2.350098-0.928223 c-0.897949,0-1.601562,0.523926-1.601562,1.272461c0,1.88623,4.999512,1.421875,4.999512,4.819824 c0,1.691895-1.287109,3.11377-3.50293,3.11377c-2.364746,0-3.666992-1.452148-3.666992-1.452148L120.13546,42.628498z M134.784393,34.545002c2.589844,0,3.921875,1.452148,3.921875,1.452148l-0.927734,1.437012 c0,0-1.212402-1.122559-2.904297-1.122559c-2.245117,0-3.5625,1.67627-3.5625,3.652344 c0,2.020508,1.362305,3.801758,3.577637,3.801758c1.841309,0,3.083496-1.347168,3.083496-1.347168l1.018066,1.39209 c0,0-1.466797,1.72168-4.17627,1.72168c-3.248535,0-5.493652-2.410156-5.493652-5.538574 C129.321014,36.910236,131.655975,34.545002,134.784393,34.545002z M142.636444,34.724689h1.931152v4.505859h4.865234v-4.505859 h1.930664v10.62793h-1.930664v-4.460938h-4.865234v4.460938h-1.931152V34.724689z M161.427948,34.724689h3.62207 c3.279297,0,5.418945,1.945801,5.418945,5.298828s-2.139648,5.329102-5.418945,5.329102h-3.62207V34.724689z M164.945526,43.690998 c2.155273,0,3.532227-1.272461,3.532227-3.66748c0-2.364746-1.40625-3.637207-3.532227-3.637207h-1.586914v7.304688H164.945526z M174.354706,34.724689h6.361328v1.661621h-4.429688v2.78418h3.577148v1.661621h-3.577148v2.858887h4.669922v1.661621h-6.601562 V34.724689z M183.465057,34.724689h2.081055l2.334961,6.930664c0.209961,0.61377,0.389648,1.556641,0.404297,1.556641h0.030273 c0.014648,0,0.194336-0.942871,0.404297-1.556641l2.349609-6.930664h2.06543l-3.876953,10.62793h-1.916016L183.465057,34.724689z M196.333221,34.724689h6.361328v1.661621h-4.430664v2.78418h3.577148v1.661621h-3.577148v2.858887h4.669922v1.661621h-6.600586 V34.724689z M206.805878,34.724689h1.931641v8.966309h4.594727v1.661621h-6.526367V34.724689z M221.321503,34.545002 c3.12793,0,5.493164,2.380371,5.493164,5.418945c0,3.128418-2.365234,5.568359-5.493164,5.568359 c-3.128906,0-5.494141-2.439941-5.494141-5.568359C215.827362,36.925373,218.192596,34.545002,221.321503,34.545002z M221.321503,43.765705c1.945312,0,3.501953-1.616211,3.501953-3.801758c0-2.095703-1.556641-3.652344-3.501953-3.652344 c-1.947266,0-3.503906,1.556641-3.503906,3.652344C217.817596,42.149494,219.374237,43.765705,221.321503,43.765705z M230.639862,34.724689h4.101562c1.990234,0,3.382812,1.39209,3.382812,3.458008c0,2.06543-1.392578,3.502441-3.382812,3.502441 h-2.170898v3.66748h-1.930664V34.724689z M234.38205,40.008869c1.12207,0,1.78125-0.71875,1.78125-1.826172 c0-1.092773-0.65918-1.796387-1.751953-1.796387h-1.84082v3.622559H234.38205z M242.234589,34.724689h2.06543l2.080078,5.253906 c0.240234,0.628906,0.539062,1.557129,0.539062,1.557129h0.030273c0,0,0.28418-0.928223,0.524414-1.557129l2.080078-5.253906 h2.066406l0.853516,10.62793h-1.916016l-0.449219-5.942871c-0.044922-0.703125-0.015625-1.646484-0.015625-1.646484h-0.029297 c0,0-0.314453,1.033203-0.569336,1.646484l-1.72168,4.116699h-1.691406l-1.706055-4.116699 c-0.254883-0.613281-0.583984-1.661133-0.583984-1.661133h-0.030273c0,0,0.030273,0.958008-0.014648,1.661133l-0.449219,5.942871 h-1.930664L242.234589,34.724689z M256.702362,34.724689h6.361328v1.661621h-4.430664v2.78418h3.577148v1.661621h-3.577148v2.858887 h4.669922v1.661621h-6.600586V34.724689z M267.175018,34.724689h1.931641l4.025391,6.137207 c0.404297,0.61377,0.883789,1.646484,0.883789,1.646484h0.030273c0,0-0.105469-1.017578-0.105469-1.646484v-6.137207h1.916016 v10.62793h-1.916016l-4.026367-6.12207c-0.404297-0.61377-0.883789-1.646973-0.883789-1.646973h-0.029297 c0,0,0.105469,1.018066,0.105469,1.646973v6.12207h-1.931641V34.724689z M282.616425,36.386311h-3.488281v-1.661621h8.90625 v1.661621h-3.487305v8.966309h-1.930664V36.386311z"/>
                    
                    ';

                    echo $background ? '<clipPath id="dd-logo-' . str_pad($index, 2, 0, STR_PAD_LEFT) . '-shape">' : null;
                    echo '<path class="dd-part-1" d="M15.49552,21.242952l3.586437,3.586437L0.206366,21.074915C0.066335,21.775103,0,22.472338,0,23.159256c0,4.96323,3.497987,9.400204,8.551135,10.405529l12.206849,2.427811c-2.358526,2.685768-4.069941,6.002449-4.836453,9.75103c-2.352633,11.511089,5.14453,22.79958,16.667404,25.090305c11.50666,2.289238,22.69051-5.182869,24.979748-16.689529c0.754726-3.794277,0.448116-7.554657-0.7164-10.971569c-2.362953-6.944386-8.263687-12.47366-15.974594-14.008171l-15.249352-3.033657L36.736996,15.02087l6.222092,6.222082c2.074032,2.07403,4.792233,3.111788,7.510437,3.111788c2.718201,0,5.436401-1.037758,7.510426-3.111788L36.736996,0L15.49552,21.242952z M38.715206,39.565765c5.834408,1.108501,9.624271,6.779285,8.417,12.594532c-1.170422,5.645721-6.711487,9.350082-12.376373,8.275471c-5.837349-1.107025-9.630152-6.78223-8.421413-12.597473C27.50779,42.191097,33.048855,38.488213,38.715206,39.565765z M36.737545,100L15.494884,78.757339l0.000008-0.000008c4.147923-4.147926,10.873035-4.147926,15.02096,0l6.221693,6.221695l13.73217-13.73217l7.510487,7.510483L36.737545,100z M58.918404,32.753075l5.996552,1.194c5.054619,1.005325,8.552612,5.442299,8.552612,10.405529c0,0.68692-0.06781,1.384155-0.206375,2.082874l-6.087944-1.21022c-5.731224-1.139462-9.441479-6.727699-8.259274-12.450077C58.916927,32.760445,58.918404,32.753075,58.918404,32.753075z" />';
                    echo $background ? '</clipPath>' : null;
                } else {
                    echo $background ? '<clipPath id="dd-logo-' . str_pad($index, 2, 0, STR_PAD_LEFT) . '-shape">' : null;
                    echo '<path class="dd-part-2" d="M67.219971,72.17981C61.5,70.999817,55.909973,74.709839,54.77002,80.439819l-1.210022,6.090027 c0.700012,0.140015,1.400024,0.200012,2.090027,0.200012c4.959961,0,9.399963-3.490051,10.399963-8.550049l1.200012-6 C67.25,72.17981,67.23999,72.17981,67.219971,72.17981z M15.02002,49.999817l6.219971-6.219971 c2.080017-2.070007,3.109985-4.790039,3.109985-7.51001c0-2.720032-1.029968-5.440002-3.109985-7.51001L0,49.999817 l21.23999,21.25l7.51001-7.51001L15.02002,49.999817z M78.76001,28.759827l-3.600037,3.599976l3.76001-18.889954 c-0.700012-0.140015-1.389954-0.200012-2.079956-0.200012c-4.960022,0-9.400024,3.48999-10.400024,8.549988L64.01001,34.019836 c-2.690002-2.349976-6.01001-4.070007-9.75-4.830017C42.75,26.839844,31.460022,34.329834,29.169983,45.859802 c-2.289978,11.5,5.179993,22.690002,16.690002,24.970032c3.790039,0.76001,7.549988,0.450012,10.970032-0.710022 c6.940002-2.359985,12.469971-8.26001,14-15.97998l3.029968-15.26001L84.97998,49.999817l-6.219971,6.230042 c-2.080017,2.069946-3.109985,4.789978-3.109985,7.509949c0,2.710022,1.029968,5.430054,3.109985,7.51001L100,49.999817 L78.76001,28.759827z M60.440002,51.979858c-1.109985,5.839966-6.789978,9.629944-12.599976,8.419983 c-5.650024-1.169983-9.350037-6.710022-8.280029-12.380005c1.109985-5.830017,6.789978-9.630005,12.599976-8.419983 C57.809998,40.769836,61.51001,46.319824,60.440002,51.979858z" />';
                    echo $background ? '</clipPath>' : null;

                    echo '
                    
                        <path d="M80.795929,30.799744l-2.491684,12.529278l-7.057442-7.057446l7.510468-7.510475L80.795929,30.799744z" style="
                            fill: #000000;
                            opacity: .1;
                        " />

                        <path class="dd-part-1" d="M66.435432,21.817457L64.00724,34.024822c-2.684952-2.359566-6.002499-4.071146-9.751064-4.837284 c-11.511066-2.352652-22.798714,5.144688-25.09079,16.667969c-2.288752,11.506561,5.183876,22.690109,16.690441,24.978905 c3.794411,0.754753,7.554729,0.448364,10.971859-0.715546c6.944374-2.363091,12.473248-8.263535,14.00713-15.97488 l8.090111-40.67173l-0.000008-0.000002C73.171577,12.327843,67.579842,16.064117,66.435432,21.817457z M47.840057,60.399193 c-5.646458-1.171688-9.350697-6.711948-8.275578-12.377586c1.107502-5.836296,6.781296-9.62923,12.597958-8.420918 c5.646778,1.173019,9.349831,6.715061,8.272583,12.38089C59.325756,57.815826,53.654655,61.605774,47.840057,60.399193z" />
                    
                    ';
                }
            } else {
                if($wordmark) {
                    echo '
                    
                        <path class="dd-part-3" d="M31.660156,146.314255h1.4375v0.371094c0,0.943359,0.516602,1.257812,1.055664,1.257812s1.021973-0.326172,1.021973-1.19043v-4.34668h-2.055176v-1.246094h3.503906v5.615234c0,1.740234-1.257812,2.493164-2.493164,2.493164c-1.224121,0-2.470703-0.774414-2.470703-2.493164V146.314255z M39.943848,141.159958h4.772949v1.246094h-3.324219v2.089844h2.684082v1.246094h-2.684082v2.144531h3.503906v1.24707h-4.952637V141.159958z M47.800293,141.159958h2.717773c2.459473,0,4.06543,1.459961,4.06543,3.975586s-1.605957,3.998047-4.06543,3.998047h-2.717773V141.159958z M50.439453,147.88652c1.617188,0,2.650391-0.954102,2.650391-2.750977c0-1.774414-1.055664-2.729492-2.650391-2.729492h-1.19043v5.480469H50.439453z M57.497559,141.159958h4.772949v1.246094h-3.324219v2.089844h2.684082v1.246094h-2.684082v2.144531h3.503906v1.24707h-4.952637V141.159958z M65.533691,147.089645c0,0,0.864746,0.841797,1.987793,0.841797c0.606445,0,1.156738-0.314453,1.156738-0.964844c0-1.426758-3.762207-1.179688-3.762207-3.62793c0-1.325195,1.145508-2.313477,2.672852-2.313477c1.572266,0,2.380859,0.853516,2.380859,0.853516l-0.628906,1.179688c0,0-0.763672-0.697266-1.763184-0.697266c-0.673828,0-1.20166,0.393555-1.20166,0.955078c0,1.415039,3.750977,1.066406,3.750977,3.616211c0,1.268555-0.96582,2.335938-2.62793,2.335938c-1.774414,0-2.751465-1.088867-2.751465-1.088867L65.533691,147.089645z M77.10498,141.159958h3.077148c1.493652,0,2.538086,1.044922,2.538086,2.59375c0,1.550781-1.044434,2.628906-2.538086,2.628906h-1.628418v2.750977h-1.44873V141.159958z M79.912598,145.124802c0.842285,0,1.336426-0.539062,1.336426-1.371094c0-0.819336-0.494141-1.347656-1.313965-1.347656h-1.381348v2.71875H79.912598z M85.399414,141.159958h1.44873v7.973633h-1.44873V141.159958z M91.932617,145.090622l-2.380859-3.930664h1.650879l1.089355,1.954102c0.258301,0.459961,0.505371,0.977539,0.505371,0.977539h0.022461c0,0,0.224609-0.505859,0.48291-0.977539l1.111816-1.954102h1.662109l-2.40332,3.930664l2.493164,4.042969h-1.628418l-1.235352-2.145508c-0.258301-0.459961-0.494141-0.943359-0.494141-0.943359h-0.022461c0,0-0.224609,0.483398-0.494141,0.943359l-1.224121,2.145508h-1.617188L91.932617,145.090622z M98.777832,141.159958h4.772461v1.246094h-3.32373v2.089844h2.684082v1.246094h-2.684082v2.144531h3.503418v1.24707h-4.952148V141.159958z M106.634277,141.159958h1.449219v6.726562h3.447266v1.24707h-4.896484V141.159958z M118.396973,147.089645c0,0,0.864258,0.841797,1.987305,0.841797c0.607422,0,1.157227-0.314453,1.157227-0.964844c0-1.426758-3.762695-1.179688-3.762695-3.62793c0-1.325195,1.146484-2.313477,2.673828-2.313477c1.572266,0,2.380859,0.853516,2.380859,0.853516l-0.628906,1.179688c0,0-0.763672-0.697266-1.763672-0.697266c-0.673828,0-1.201172,0.393555-1.201172,0.955078c0,1.415039,3.75,1.066406,3.75,3.616211c0,1.268555-0.964844,2.335938-2.626953,2.335938c-1.775391,0-2.751953-1.088867-2.751953-1.088867L118.396973,147.089645z M125.837402,141.159958h1.449219v7.973633h-1.449219V141.159958z M132.358887,142.406052h-2.616211v-1.246094h6.682617v1.246094h-2.617188v6.727539h-1.449219V142.406052z M138.29541,148.200974l3.538086-5.076172c0.314453-0.459961,0.583984-0.71875,0.583984-0.71875v-0.021484c0,0-0.224609,0.021484-0.595703,0.021484h-3.34668v-1.246094h5.760742v0.920898l-3.537109,5.086914c-0.314453,0.460938-0.583984,0.71875-0.583984,0.71875v0.023438c0,0,0.224609-0.023438,0.595703-0.023438h3.570312v1.24707h-5.985352V148.200974z M148.825684,142.406052h-2.617188v-1.246094h6.681641v1.246094h-2.616211v6.727539h-1.448242V142.406052z M154.470215,147.706833h1.425781v1.426758h-1.425781V147.706833z" />
                        <path class="dd-part-2" d="M0,121.242958h3.622559c3.27832,0,5.418457,1.946289,5.418457,5.298828c0,3.353523-2.140137,5.329109-5.418457,5.329109H0V121.242958z M3.517578,130.209763c2.155762,0,3.532715-1.272461,3.532715-3.667976c0-2.365234-1.407227-3.637695-3.532715-3.637695H1.931152v7.305672H3.517578z M12.926758,121.242958h1.931152v10.627937h-1.931152V121.242958z M19.659668,129.146286c0,0,1.152344,1.123047,2.649414,1.123047c0.808105,0,1.541504-0.418945,1.541504-1.287109c0-1.901375-5.014648-1.572273-5.014648-4.834969c0-1.766602,1.526855-3.083984,3.562988-3.083984c2.095703,0,3.17334,1.137695,3.17334,1.137695l-0.838379,1.571289c0,0-1.018066-0.927734-2.350098-0.927734c-0.897949,0-1.601562,0.524414-1.601562,1.272461c0,1.885742,4.999512,1.421875,4.999512,4.82032c0,1.691406-1.287109,3.113281-3.50293,3.113281c-2.364746,0-3.666992-1.452148-3.666992-1.452148L19.659668,129.146286z M34.308594,121.063271c2.589844,0,3.921875,1.452148,3.921875,1.452148l-0.927734,1.436523c0,0-1.212402-1.12207-2.904297-1.12207c-2.245117,0-3.5625,1.676758-3.5625,3.652344c0,2.020515,1.362305,3.801765,3.577637,3.801765c1.841309,0,3.083496-1.34668,3.083496-1.34668l1.018066,1.391602c0,0-1.466797,1.72168-4.17627,1.72168c-3.248535,0-5.493652-2.410156-5.493652-5.538094C28.845215,123.428505,31.180176,121.063271,34.308594,121.063271z M42.160645,121.242958h1.931152v4.505859h4.864746v-4.505859h1.931152v10.627937h-1.931152v-4.460945h-4.864746v4.460945h-1.931152V121.242958z M60.952148,121.242958h3.622559c3.27832,0,5.418457,1.946289,5.418457,5.298828c0,3.353523-2.140137,5.329109-5.418457,5.329109h-3.622559V121.242958z M64.469727,130.209763c2.155762,0,3.532715-1.272461,3.532715-3.667976c0-2.365234-1.407227-3.637695-3.532715-3.637695h-1.586426v7.305672H64.469727z M73.878906,121.242958h6.361816v1.661133h-4.430664v2.78418h3.577637v1.662109h-3.577637v2.859383h4.669922v1.661133h-6.601074V121.242958z M82.989258,121.242958h2.081055l2.334961,6.930672c0.209473,0.613281,0.38916,1.556641,0.404297,1.556641h0.029785c0.015137,0,0.194336-0.943359,0.404297-1.556641l2.350098-6.930672h2.06543l-3.876953,10.627937h-1.916016L82.989258,121.242958z M95.856934,121.242958h6.361816v1.661133h-4.430664v2.78418h3.577637v1.662109h-3.577637v2.859383h4.67041v1.661133h-6.601562V121.242958z M106.330566,121.242958h1.930664v8.966805h4.595703v1.661133h-6.526367V121.242958z M120.845215,121.063271c3.12793,0,5.493164,2.379883,5.493164,5.418945c0,3.127937-2.365234,5.568367-5.493164,5.568367c-3.128906,0-5.494141-2.44043-5.494141-5.568367C115.351074,123.443153,117.716309,121.063271,120.845215,121.063271z M120.845215,130.283981c1.946289,0,3.50293-1.616211,3.50293-3.801765c0-2.095703-1.556641-3.652344-3.50293-3.652344s-3.50293,1.556641-3.50293,3.652344C117.342285,128.66777,118.898926,130.283981,120.845215,130.283981z M130.163574,121.242958h4.100586c1.991211,0,3.383789,1.392578,3.383789,3.458008s-1.392578,3.502937-3.383789,3.502937h-2.169922v3.666992h-1.930664V121.242958z M133.905762,126.527138c1.12207,0,1.78125-0.71875,1.78125-1.826172c0-1.092773-0.65918-1.796875-1.751953-1.796875h-1.84082v3.623047H133.905762z M141.758301,121.242958h2.066406l2.080078,5.253906c0.239258,0.628906,0.539062,1.556648,0.539062,1.556648h0.030273c0,0,0.28418-0.927742,0.523438-1.556648l2.081055-5.253906h2.06543l0.853516,10.627937h-1.916016l-0.449219-5.94239c-0.044922-0.704102-0.014648-1.646484-0.014648-1.646484h-0.030273c0,0-0.314453,1.032227-0.569336,1.646484l-1.720703,4.116219h-1.691406l-1.707031-4.116219c-0.253906-0.614258-0.583984-1.662109-0.583984-1.662109h-0.029297c0,0,0.029297,0.958008-0.015625,1.662109l-0.448242,5.94239h-1.931641L141.758301,121.242958z M156.227051,121.242958h6.361328v1.661133h-4.430664v2.78418h3.577148v1.662109h-3.577148v2.859383h4.669922v1.661133h-6.600586V121.242958z M166.699707,121.242958h1.930664l4.026367,6.137695c0.404297,0.613281,0.882812,1.646492,0.882812,1.646492h0.030273c0,0-0.104492-1.018555-0.104492-1.646492v-6.137695h1.916016v10.627937h-1.916016l-4.026367-6.122078c-0.404297-0.614258-0.883789-1.646484-0.883789-1.646484h-0.029297c0,0,0.104492,1.017578,0.104492,1.646484v6.122078h-1.930664V121.242958z M182.140137,122.904091h-3.488281v-1.661133h8.907227v1.661133h-3.488281v8.966805h-1.930664V122.904091z" />
                    
                    ';

                    echo $background ? '<clipPath id="dd-logo-' . str_pad($index, 2, 0, STR_PAD_LEFT) . '-shape">' : null;
                    echo '<path class="dd-part-1" d="M72.539452,21.242952l3.586441,3.586437l-18.875595-3.754475c-0.14003,0.700188-0.206364,1.397423-0.206364,2.084341c0,4.96323,3.497986,9.400204,8.551136,10.405529l12.206848,2.427811c-2.358528,2.685768-4.069939,6.002449-4.836456,9.75103c-2.352631,11.511089,5.144531,22.79958,16.667404,25.090305c11.506668,2.289238,22.690514-5.182869,24.979752-16.689529c0.75473-3.794277,0.44812-7.554657-0.7164-10.971569c-2.362953-6.944386-8.263687-12.47366-15.974594-14.008171l-15.249352-3.033657L93.78093,15.02087l6.222092,6.222082c2.074028,2.07403,4.792236,3.111788,7.510437,3.111788s5.436401-1.037758,7.510422-3.111788L93.78093,0L72.539452,21.242952z M95.75914,39.565762c5.834412,1.108501,9.624268,6.779289,8.417,12.594536c-1.170418,5.645721-6.711487,9.350082-12.376373,8.275471c-5.837349-1.107025-9.63015-6.78223-8.421417-12.597473C84.55172,42.191097,90.092789,38.488213,95.75914,39.565762z M93.781479,100L72.538818,78.757339l0.000008-0.000008c4.147926-4.147926,10.873039-4.147926,15.020958,0l6.221695,6.221695l13.73217-13.73217l7.51049,7.510483L93.781479,100z M115.962334,32.753075l5.996559,1.194c5.054611,1.005325,8.552612,5.442299,8.552612,10.405529c0,0.68692-0.06781,1.384155-0.206375,2.082874l-6.087952-1.21022c-5.731216-1.139462-9.441475-6.727699-8.25927-12.450077C115.960861,32.760445,115.962334,32.753075,115.962334,32.753075z" />';
                    echo $background ? '</clipPath>' : null;
                } else {
                    echo $background ? '<clipPath id="dd-logo-' . str_pad($index, 2, 0, STR_PAD_LEFT) . '-shape">' : null;
                    echo '<path class="dd-part-1" d="M28.761736,21.242952l3.586439,3.586437l-18.875593-3.754475c-0.140031,0.700188-0.206366,1.397423-0.206366,2.084341 c0,4.96323,3.497988,9.400204,8.551136,10.405529L34.0242,35.992596c-2.358526,2.685768-4.069941,6.002449-4.836452,9.75103 c-2.352633,11.511089,5.144527,22.79958,16.667404,25.090305c11.50666,2.289238,22.69051-5.182869,24.979748-16.689529 c0.75473-3.794277,0.44812-7.554657-0.7164-10.971569c-2.362953-6.944386-8.263687-12.47366-15.974594-14.008171 l-15.249352-3.033657L50.003212,15.02087l6.222092,6.222082c2.074032,2.07403,4.792233,3.111788,7.510437,3.111788 c2.718201,0,5.436401-1.037758,7.510429-3.111788L50.003212,0L28.761736,21.242952z M51.981422,39.565765 c5.834408,1.108501,9.624271,6.779285,8.417,12.594532c-1.170422,5.645721-6.711487,9.350082-12.376373,8.275471 c-5.837349-1.107025-9.63015-6.78223-8.421413-12.597473C40.774006,42.191097,46.315071,38.488213,51.981422,39.565765z M50.003761,100L28.761101,78.757339l0.000008-0.000008c4.147923-4.147926,10.873035-4.147926,15.020958,0l6.221691,6.221695 l13.73217-13.73217l7.510487,7.510483L50.003761,100z M72.184616,32.753075l5.996552,1.194 c5.054626,1.005325,8.552612,5.442299,8.552612,10.405529c0,0.68692-0.06781,1.384155-0.206375,2.082874l-6.087936-1.21022 c-5.731232-1.139462-9.441483-6.727699-8.259277-12.450077C72.183144,32.760445,72.184616,32.753075,72.184616,32.753075z" />';
                    echo $background ? '</clipPath>' : null;
                }
            }
            ?>
        
        </svg>

        <?php
        $index++;
    }

    public static function mail($message, $footer = null, $template = 'default')
    {

        $message = $message . dd::settings('mail', 'signature');
        $template = file_get_contents(dd::documentRoot() . '/theme/mail/template-' . $template . '.html');
        $values = null;
        $wildcards = null;

        if($footer) {
            $footer = '

                <p style="font-size: 87.5%;">&nbsp;</p>

                <p style="font-size: 87.5%;">&nbsp;</p>

                ' . $footer . '

            ';

            $message = $message . $footer;
        }

        $attributes = [
            'message' => trim($message),
        ];

        if(preg_match_all('/##+(.*?)##/', $template, $matches)) {
            foreach($matches[1] as $value) {
                $wildcards[] = '##' . $value . '##';

                if(is_array($attributes)) {
                    $values[] = $attributes[$value];
                }
            }
        }

        return str_replace($wildcards, $values, $template);
    }

    public static function nav($categories)
    {
        foreach($categories as $value) {
            if(in_array($value['id'], [24, 34])) {
                continue;
            }

            echo '<li><a class="dd-icon" href="';

            if(
                rex_article::getCurrent()->getTemplateId() == 1 ||
                (
                    rex_article::getCurrent()->getTemplateId() == 7 &&
                    $value['anchor'] == 'kontakt'

                )
            ) {
                if($value['single']) {
                    echo rex_getUrl($value['id']);
                } else {
                    echo 'javascript:;" data-target="#';

                    if($value['anchor']) {
                        echo $value['anchor'];
                    } else {
                        echo 'dd-article-' . str_pad($value['id'], 6, 0, STR_PAD_LEFT);
                    }
                }
            } else {
                if($value['single']) {
                    echo rex_getUrl($value['id']);
                } else {
                    echo self::homeLink() . '#';

                    if($value['anchor']) {
                        echo $value['anchor'];
                    } else {
                        echo 'dd-article-' . str_pad($value['id'], 6, 0, STR_PAD_LEFT);
                    }
                }
            }

            echo '" title="' . $value['name'] . '" data-tooltip>' . file_get_contents('theme/public/assets/frontend/new/images/icon-' . $value['icon'] . '.svg') . '</a></li>';
        }
    }

    public static function newsletterForm($header = null)
    {
        ?>

        <section id="dd-section-newsletter-form" class="dd-min-h-0 dd-section-newsletter-form" data-scroll-section>
            <div class="dd-container" data-scroll>
                <?php echo $header; ?>

                <ul class="dd-alerts" style="
                    margin-bottom: 4rem;
                    <?php echo $header ? 'margin-top: 4rem;' : null; ?>
                "></ul>

                <form style="
                    <?php echo $header ? 'margin-top: 4rem;' : null; ?>
                ">
                    <div class="dd-form-row dd-form-row-rule">
                        <div class="dd-col-12 dd-col-lg-6">
                            <div class="dd-form-group">
                                <label>Wie lautet deine E-Mail-Adresse?</label>
                                <input name="email" type="email" autocomplete="off" />
                                <div class="dd-alert">–</div>
                            </div>
                        </div>

                        <div class="dd-col-12 dd-col-lg-6">
                            <div class="dd-form-group">
                                <label>Wie darf ich dich ansprechen?</label>
                                <input name="callname" type="text" autocomplete="off" />
                                <div class="dd-alert">–</div>
                            </div>
                        </div>
                    </div>

                    <input name="honeypot" type="email" autocomplete="off" />

                    <p class="dd-fs-xs" style="
                        margin-top: 2rem;
                    ">Ich nehme den Schutz persönlicher Daten sehr ernst und versuche, ihn auch technisch zu gewährleisten. Garantieren kann ich ihn technisch aber nicht, weil Angriffe durch Hacker immer möglich sind. Mehr dazu erfährst du in meiner <a href="<?php echo rex_getUrl(29); ?>">Datenschutzerklärung</a>.</p>

                    <ul class="dd-call-to-actions">
                        <?php echo '<li>' . self::callToAction(
                            'Senden',
                            'javascript:;',
                            'data-action="submit"'
                        ) . '</li>'; ?>
                    </ul>
                </form>
            </div>
        </section>

        <?php
    }

    public static function opening($callToAction = false, $class = null, $attributes = null)
    {
        echo '<div class="dd-container' . ($class ? ' ' . $class : null) . '"' . ($attributes ? ' ' . $attributes : null) . '>';
        
        if(!$callToAction) {
            // echo '<h2 class="dd-tagline">Klassische Websites und komplexere digitale Lösungen</h2>';

            echo '<h2 class="dd-tagline">Agentur für Webdesign und SEO in Malans (bei Landquart) in Graubünden</h2>';
        }

        echo '<p class="dd-display-4">Dein Webauftritt ist in die Jahre gekommen und braucht einen neuen Anstrich? Oder neue Funktionen, die dir Arbeit abnehmen? Neben klassischen Websites, die deine Produkte und ihre Vorteile präsentieren, entwickle ich auch Webanwendungen. Schnittstellen zu <a href="https://www.calendly.com" target="_blank" rel="noopener noreferrer" title="Website von Calendly">Calendly</a>, <a href="https://www.twilio.com" target="_blank" rel="noopener noreferrer" title="Website von Twilio in San Francisco (Vereinigte Staaten)">Twilio</a>, <a href="https://www.getharvest.com" target="_blank" rel="noopener noreferrer" title="Website von Harvest in New York City (Vereinigte Staaten)">Harvest</a> und weiteren ermöglichen fast alles.</p>';

        if($callToAction) {
            echo '

                <ul class="dd-call-to-actions">
                    <li data-ajax-meetings>' . self::loader() . '</li>
                </ul>
            
            ';
        }

        echo '</div>';
    }

    public static function picture($filePath, $title = null)
    {
        $extension = explode('.', $filePath);

        $filePath = array_key_exists(1, $extension) ? $extension[0] : $filePath;
        $extension = array_key_exists(1, $extension) ? $extension[1] : 'jpg';
        ?>

        <figure>
            <picture>
                <source
                data-srcset="
                    /<?php echo $filePath; ?>-800.webp 800w,
                    /<?php echo $filePath; ?>-1600.webp 1600w,
                    /<?php echo $filePath; ?>-2400.webp 2400w
                "
                sizes="100vw"
                type="image/webp"
                />

                <source
                data-srcset="
                    /<?php echo $filePath; ?>-800.<?php echo $extension; ?> 800w,
                    /<?php echo $filePath; ?>-1600.<?php echo $extension; ?> 1600w,
                    /<?php echo $filePath; ?>-2400.<?php echo $extension; ?> 2400w
                "
                sizes="100vw"
                type="image/jpg"
                />

                <img
                data-srcset="
                    /<?php echo $filePath; ?>-800.<?php echo $extension; ?> 800w,
                    /<?php echo $filePath; ?>-1600.<?php echo $extension; ?> 1600w,
                    /<?php echo $filePath; ?>-2400.<?php echo $extension; ?> 2400w
                "
                data-src="/<?php echo $filePath; ?>-1600.<?php echo $extension; ?>"
                alt="<?php echo $title; ?>"
                title="<?php echo $title; ?>"
                class="lazy"
                />
            </picture>
        </figure>

        <?php
    }

    public static function posts($post)
    {
        ?>

        <section class="dd-section-posts" data-scroll-section>
            <div class="dd-container">
                <ul class="dd-hero-list">
                    <?php
                    $posts = [
                        0 => [],
                        1 => [],
                    ];

                    foreach(dd_data::posts([1, 2, 3]) as $value) {
                        if($value['createdate'] < $post->getValue('createdate') || $value['id'] == $post->getValue('id')) {
                            continue;
                        }

                        $posts[0][] = $value;
                    }

                    $posts[0] = array_reverse($posts[0]);
                    $posts[0] = array_slice($posts[0], 0, 3);
                    $posts[0] = array_reverse($posts[0]);

                    foreach(dd_data::posts([1, 2, 3]) as $value) {
                        if($value['createdate'] > $post->getValue('createdate') || $value['id'] == $post->getValue('id')) {
                            continue;
                        }

                        $posts[1][] = $value;
                    }

                    $posts[1] = array_slice($posts[1], 0, 3);

                    $posts = array_merge($posts[0], $posts[1]);
                    $posts = array_chunk($posts, 3);

                    if(array_key_exists(1, $posts)) {
                        $posts[0] = array_reverse($posts[0]);
                        $posts[0] = array_slice($posts[0], 0, 2);
                        $posts[0] = array_reverse($posts[0]);

                        $posts[1] = array_slice($posts[1], 0, 1);

                        $posts = array_merge($posts[0], $posts[1]);
                    } else {
                        $posts = $posts[0];
                    }

                    foreach($posts as $value) {
                        echo '

                            <li>
                                <a href="' . rex_getUrl('', '', ['post_id' => $value['id']]) . '" class="dd-post">
                                    ' . $value['title'] . '
                                </a>
                            </li>

                        ';
                    }
                    ?>
                </ul>
            </div>
        </section>

        <?php
    }

    public static function rule($clock = false)
    {
        ?>

        <div class="dd-rule<?php echo $clock ? ' dd-rule-clock' : null; ?>" data-scroll-section>
            <?php echo $clock ? self::clock() : null; ?>
        </div>

        <?php
    }

    public static function tokenForm($article = null, $post = null)
    {
        ?>

        <section id="dd-section-token-form" class="dd-min-h-0 dd-section-token-form" data-scroll-section>
            <div class="dd-container" data-scroll>
                <p style="
                    margin-bottom: 4rem;
                ">Dieser Bereich ist geschützt und nur durch einen persönlichen Link zugänglich, weil er vertrauliche Informationen enthalten kann. Identifiziere dich bitte mit der E-Mail-Adresse, an die ich dir normalerweise schreibe, um einen persönlichen Link zu erhalten!</p>

                <ul class="dd-alerts" style="
                    margin-bottom: 4rem;
                "></ul>

                <form data-article="<?php echo $article; ?>" data-post="<?php echo $post; ?>">
                    <div class="dd-form-row dd-form-row-rule">
                        <div class="dd-col-12">
                            <div class="dd-form-group">
                                <label>Wie lautet deine E-Mail-Adresse?</label>
                                <input name="identifier" type="text" autocomplete="off" />
                                <div class="dd-alert">–</div>
                            </div>
                        </div>
                    </div>

                    <input name="honeypot" type="email" autocomplete="off" />

                    <ul class="dd-call-to-actions">
                        <?php echo '<li>' . self::callToAction(
                            'Senden',
                            'javascript:;',
                            'data-action="submit"'
                        ) . '</li>'; ?>
                    </ul>
                </form>
            </div>
        </section>

        <?php
    }

    public static function video($filePath, $title = null, $parameter = null)
    {
        ?>

        <figure>
            <video
            class="lazy video-js"
            controls
            data-setup='{}'
            playsinline
            preload="none"
            data-poster="/<?php echo $filePath; ?>-1600.jpg"
            >
                <source data-src="/<?php echo $filePath; ?>-1600.webm" type="video/webm" />
                <source data-src="/<?php echo $filePath; ?>-1600.mp4" type="video/mp4" />
            </video>

            <?php /*
            <figcaption>Test</figcaption>
            */ ?>
        </figure>

        <?php
    }
}
