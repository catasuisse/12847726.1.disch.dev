<?php
if($this->getTemplateId() != 1 && class_exists('Url\Url') && Url\Url::resolveCurrent()) {

    $manager = Url\Url::resolveCurrent();
    $permission = true;
    $session = dischdev()->session();

    $post = rex_yform_manager_table::get('dd_post')
        ->query()
        ->findId($manager->getDatasetId());
    $token = $session ? $session['token'] : null;

    if(in_array($post->getValue('audiences'), [1,9]) && !dischdev()->permission(null, $post->getValue('id'))) {
        $permission = false;
    }

    if($permission) {

        $archive = dd_post()->archive($post->getValue('id'));
        $clock = true;
        $images = $post->getValue('images');
        $include = $post->getValue('include');
        $receiver = $token ? dd_data()->receiver(['token' => $token]) : false;

        $receiverAudiences = $receiver ? explode(',', $receiver['audiences']) : false;

        $images = explode(',', $images);
        $images = array_filter($images);
        $images = array_values($images);

        if($images) {
            ?>

            <section class="dd-min-h-0 dd-pt-xl-0" data-scroll-section>
                <div class="dd-exhibits" data-visible-items="3">
                    <?php
                    $index = 0;

                    foreach($images as $value) {
                        $imageTitle = rex_media::get($value);
                        $imageTitle = isset($imageTitle) ? $imageTitle->getTitle() : null;
                        ?>

                        <div class="dd-exhibit<?php echo $index > 2 ? ' dd-d-none' : null; ?>" data-scroll>
                            <figure>
                                <picture>
                                    <source
                                    data-srcset="
                                        <?php echo rex_media_manager::getUrl('dd_16x9_800', $value); ?> 800w,
                                        <?php echo rex_media_manager::getUrl('dd_16x9_1600', $value); ?> 1600w,
                                        <?php echo rex_media_manager::getUrl('dd_16x9_2400', $value); ?> 2400w
                                    "
                                    sizes="100vw"
                                    type="image/jpg"
                                    />

                                    <img
                                    data-srcset="
                                        <?php echo rex_media_manager::getUrl('dd_16x9_800', $value); ?> 800w,
                                        <?php echo rex_media_manager::getUrl('dd_16x9_1600', $value); ?> 1600w,
                                        <?php echo rex_media_manager::getUrl('dd_16x9_2400', $value); ?> 2400w
                                    "
                                    data-src="<?php echo rex_media_manager::getUrl('dd_16x9_1600', $value); ?>"
                                    alt="<?php echo $imageTitle; ?>"
                                    title="<?php echo $imageTitle; ?>"
                                    class="lazy"
                                    />
                                </picture>
                            </figure>
                        </div>

                        <?php
                        $index++;
                    }
                    ?>

                    <div class="dd-exhibit-loader-wrapper" data-scroll>
                        <a class="dd-exhibit-loader dd-d-none" href="javascript:;">
                            <?php echo file_get_contents('theme/public/assets/frontend/new/images/icon-arrow-down.svg'); ?>
                        </a>
                    </div>
                </div>
            </section>

            <?php
        }

        if($include) {
            require_once(rex_path::base('theme/content/' . $include . '.php'));
        }

        if($post->getValue('content_original') || $post->getValue('content_truncated')) {
            if($images || $include) {
                echo '<section class="dd-space-less" data-scroll-section></section>';
            }
            ?>

            <section class="dd-min-h-0" data-scroll-section>
                <div class="dd-container" data-scroll>
                    <?php
                    echo dischdev()->paragraphs($post->getValue('content_original') ? $post->getValue('content_original') : $post->getValue('content_truncated'));

                    echo '<p class="dd-metadata">' . dischdev()->metadata(strtotime($post->getValue('createdate'))) . '</p>';
                    ?>
                </div>
            </section>

            <?php
        }

        if(!$token || ($receiverAudiences && !in_array(2, $receiverAudiences))) {
            dd_part()->rule($clock);

            $clock = false;
            
            $header = '

                <p>Ich reise seit 2019 als digitaler Nomade um die Welt. Alles, was ich noch besitze, passt in einen Rucksack. Und der passt unter den Vordersitz in einem Flugzeug. Abonniere jetzt meinen Newsletter, wenn du mich virtuell auf meinen Reisen begleiten möchtest!</p>
            
            ';

            dd_part()->newsletterForm($header);
        }

        if($token || $post->getValue('comments')) {
            dd_part()->rule($clock);

            $clock = false;

            dd_part()->commentForm($post->getValue('id'), $token);

            dd_part()->comments($post->getValue('id'));
        } else if($archive) {
            dd_part()->archive($archive);
        }
        ?>

        <section id="dd-section-opening" class="dd-min-h-0 dd-section-opening" data-scroll-section>
            <?php echo dd_part()->opening(false, null, 'data-scroll'); ?>
        </section>

        <?php

    } else {

        dd_part()->tokenForm(null, $post->getValue('id'));

    }

} else {

    $newestFavoritePost = dd_post()->newestFavorite();

    if(!$newestFavoritePost) {
        $newestFavoritePost = dd_post()->newest();
    }

    if($newestFavoritePost) {
        dischdev()->redirect('', '', ['post_id' => $newestFavoritePost['id']]);
    }

}
?>
