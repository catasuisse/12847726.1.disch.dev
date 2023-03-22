<?php
if(dd_data()->projects()) {
    ?>

    <section id="dd-section-projects-part-1" class="dd-section-projects" data-scroll-section>
        <div class="dd-exhibits">
            <?php
            $index = [0, 0];

            foreach(dd_data()->projects() as $value) {
                $credits = dd::paragraphs($value['credits']);
                $parameter = null;
                $type = $value['type'];
                $url = null;

                $credits = str_replace('</p><p>', '. – ', $credits);
                $credits = str_replace('.. – ', '. – ', $credits);
                $credits = str_replace(['<p>', '</p>'], null, $credits);

                if(array_key_exists('url', $value) && $value['url']) {
                    $url = $value['url'];
                } else if(array_key_exists('post', $value) && $value['post']) {
                    $url = rex_getUrl('', '', ['post_id' => $value['post']]);
                }

                if($url) {
                    $parameter .= ' href="' . $url . '"';

                    if(array_key_exists('url', $value) && $value['url']) {
                        $parameter .= ' target="_blank"';
                    }

                    $parameter .= ' title="' . $value['title'] . '" data-tooltip="true"';
                }

                echo '

                    <div class="dd-exhibit' . ($index[0] > 8 ? ' dd-d-none' : null) . '" data-scroll>
                        <' . ($url ? 'a' : 'div') . $parameter . '>

                ';

                dd_part()->$type(
                    'projects/' . $value['id'] . '-' . $value['filename'] . '/' .  $value['filename'],
                    $value['title']
                );

                echo '</' . ($url ? 'a' : 'div') . '>';

                if(array_key_exists('credits', $value) && $value['credits']) {
                    echo '
                                        
                        <div class="dd-credits">
                            <p>' . $credits . '</p>
                        </div>
                    
                    ';
                }

                echo '</div>';

                $index[0]++;

                if($index[0] == 6) {
                    echo '

                            </div>
                        </section>

                    ';
                    ?>

                    <section id="dd-section-journal" class="dd-section-journal" data-scroll-section>
                        <div class="dd-h-consistent dd-tiles">
                            <?php
                            $index[1] = 0;

                            foreach(dd_data()->posts(2) as $value) {
                                if(!$value['content_original']) {
                                    continue;
                                }
                                ?>

                                <a href="<?php echo rex_getUrl('', '', ['post_id' => $value['id']]); ?>" class="dd-tile" data-scroll>
                                    <p><?php echo $value['content_truncated']; ?></p>
                                    <p class="dd-metadata"><?php echo dischdev()->metadata(strtotime($value['createdate'])); ?></p>
                                </a>

                                <?php
                                $index[1]++;

                                if($index[1] > 2) {
                                    break;
                                }
                            }
                            ?>
                        </div>
                    </section>

                    <section id="dd-section-opening" class="dd-min-h-0 dd-section-opening" data-scroll-section>
                        <div class="dd-container" data-scroll>
                            <h2 class="dd-tagline">Agentur für Webdesign und SEO in Malans (bei Landquart) in Graubünden</h2>

                            <p class="dd-display-4">Mein Name ist Maik Disch. Ich komme aus <a href="<?php echo rex_getUrl(64); ?>" title="Webdesigner aus Malans im Kanton Graubünden">Malans</a> (bei <a href="<?php echo rex_getUrl(61); ?>" title="Webdesigner für Landquart in Graubünden">Landquart</a>) in <a href="<?php echo rex_getUrl(57); ?>" title="Webdesigner aus Graubünden in der Schweiz">Graubünden</a>, entwerfe Websites und Logos und entwickle die Websites anschliessend selbst. So, dass sie von Suchmaschinen gut gefunden werden (SEO) und mit Erfahrung seit 1998, die ich auch in Agenturen sammeln konnte. Seit 2019 bin ich ein <a href="javascript:;" data-target="#dd-section-about-me" title="Maik Disch im im Schweizer Radio und Fernsehen (SRF)">digitaler Nomade</a>.</p>
                        </div>
                    </section>

                    <?php
                    require_once('partners.php');
                    
                    echo '

                        <section id="dd-section-projects-part-2" class="dd-section-projects" data-scroll-section>
                            <div class="dd-exhibits" data-visible-items="6">

                    ';
                }
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
