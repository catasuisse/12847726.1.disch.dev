<?php
if(dd_data()->posts([3])) {
    ?>

    <section id="dd-section-posts" class="dd-section-posts" data-scroll-section>
        <div class="dd-gallery dd-gallery-data">
            <?php
            foreach(dd_data()->posts([3]) as $value) {
                $link = $value['content_original'] ? rex_getUrl('', '', ['post_id' => $value['id']]) : null;

                $icon = $link ? file_get_contents('theme/public/assets/frontend/new/images/icon-arrow-right.svg') : null;
                ?>

                <<?php echo $link ? 'a href="' . $link . '"' : 'div'; ?> class="dd-gallery-item dd-d-none" data-scroll>
                    <p><?php echo $value['content_truncated']; ?></p>
                    <p><?php echo dischdev()->date(strtotime($value['createdate'])); ?></p>
                    <?php echo $icon; ?>
                </<?php echo $link ? 'a' : 'div'; ?>>

                <?php
            }
            ?>

            <div class="dd-gallery-loader-wrapper" data-scroll>
                <a class="dd-gallery-loader dd-display-2 dd-d-none" href="javascript:;">Mehr anzeigen</a>
            </div>
        </div>
    </section>

    <?php
}
?>
