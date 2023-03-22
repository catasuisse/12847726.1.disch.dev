<?php
$catchment = dd_data()->catchment();
$description = dd_seo()->get('description')[0];
$services = dischdev()->data('services');
$title = dd_seo()->get('title');
$projects = dd_data()->projects(true);

if(count($projects) < 6) {
    $projects = dd_data()->projects();
}

shuffle($projects);
?>

<!doctype html>
<html lang="<?php echo rex_clang::getCurrent()->getCode(); ?>">
    <?php require_once('partials/head.php'); ?>

    <body class="dd-loading-state-1 dd-loading-state-2 -dd-scroll-t-05 dd-template-landing-1">
        <div class="dd-main-wrapper">
            <main data-scroll-container>
                <?php require_once('partials/intro.php'); ?>

                <header data-scroll-section>
                    <div data-scroll>
                        <?php echo dd_part()->background($catchment['image'] ? $catchment['image'] : 'background-202302212323'); ?>

                        <div class="dd-container">
                            <h1 class="dd-tagline"><?php echo $title[0]; ?></h1>
                            
                            <p class="dd-display-3"><?php echo $description; ?></p>

                            <ul class="dd-call-to-actions">
                                <?php
                                echo '<li>' . dd_part()->callToAction(
                                    'Weiterlesen',
                                    'javascript:;',
                                    'data-target="#projekte"'
                                ) . '</li>';
                                ?>
                            </ul>
                        </div>
                    </div>
                </header>

                <div id="projekte" class="dd-article" data-scroll-section></div>

                <?php
                if($projects) {
                    ?>
                
                    <section id="dd-section-projects" class="dd-section-projects" data-scroll-section>
                        <div class="dd-exhibits">
                            <?php
                            $index = 0;
                
                            foreach($projects as $value) {
                                $credits = dd::paragraphs($value['credits']);
                                $type = $value['type'];

                                $credits = str_replace('</p><p>', '. – ', $credits);
                                $credits = str_replace('.. – ', '. – ', $credits);
                                $credits = str_replace(['<p>', '</p>'], null, $credits);
                
                                echo '
                
                                    <div class="dd-exhibit' . ($index > 5 ? ' dd-d-none' : null) . '" data-scroll>
                                        <div>
                
                                ';
                
                                dd_part()->$type(
                                    'projects/' . $value['id'] . '-' . $value['filename'] . '/' .  $value['filename'],
                                    $value['title']
                                );
                
                                echo '</div>';

                                if(array_key_exists('credits', $value) && $value['credits']) {
                                    echo '
                                                        
                                        <div class="dd-credits">
                                            <p>' . $credits . '</p>
                                        </div>
                                    
                                    ';
                                }

                                echo '</div>';

                                $index++;

                                if($index == 3) {
                                    echo '

                                            </div>
                                        </section>

                                    ';
                                    ?>

                                    <section id="dd-section-expertise" class="dd-min-h-0 dd-section-expertise" data-scroll-section>
                                        <div class="dd-container" data-scroll>
                                            <h2 class="dd-text-gradient">Bester <?php echo $catchment['title'][4][0]; ?>?</h2>
                                            
                                            <p>Wenn du bei Google, Bing, Yahoo! oder einer anderen Suchmaschine nach «<?php echo $catchment['title'][4][0]; ?>» oder ähnlichen Begriffen bzw. Phrasen suchst, fällt dir vermutlich auf, wie viele es von uns gibt und fragst dich vielleicht, welcher davon der beste für dich ist. Ich würde nie behaupten, der beste <?php echo $catchment['title'][4][0]; ?> zu sein! Viele meiner Kolleginnen und Kollegen leisten hervorragende Arbeit. Vielleicht bin ich aber der beste für dich! Weil ich bieten kann, was du benötigst. Oder dir jemanden empfehle, wenn ich es nicht kann. Auch ich suche Herausforderungen. Überforderungen werden in unserer Branche aber schnell heikel.</p>

                                            <p>Wenn es dir egal ist, dass deine Website von der Stange kommt und dir die Suchmaschinenoptimierung (SEO) selbst zutraust, findest du auch bei <a href="https://www.jimdo.com" target="_blank" rel="noopener norefferer" title="Website von Jimdo in Hamburg (Deutschland)">Jimdo</a>, <a href="https://www.squarespace.com" target="_blank" rel="noopener norefferer" title="Website von Squarespace in New York City (Vereinigte Staaten)">Squarespace</a>, <a href="https://www.wix.com" target="_blank" rel="noopener norefferer" title="Website von Wix in Tel Aviv (Israel)">Wix</a> und weiteren Lieferanten von «Templates», wonach du suchst.</p>

                                            <p>Leider gibt es übrigens auch einige <?php echo $catchment['keyword'][1]; ?>, die solche Templates einsetzen und ihre Arbeit überteuert verkaufen. Auch in <?php echo $catchment['title'][0][0]; ?>. Viele dieser Templates sind nämlich kostenlos und es ist leicht nachzuweisen, wenn solche Templates eingesetzt wurden. Ein kurzer Blick in den Quelltext genügt. Einige dieser <?php echo $catchment['keyword'][1]; ?> haben noch nie etwas von <a href="https://www.w3schools.com/html" target="_blank" rel="noopener norefferer" title="«Hypertext Markup Language» (HTML) bei W3Schools">HTML</a>, <a href="https://www.w3schools.com/css" target="_blank" rel="noopener norefferer" title="«Cascading Style Sheets» (CSS) bei W3Schools">CSS</a>, <a href="https://www.w3schools.com/js" target="_blank" rel="noopener norefferer" title="«JavaScript» bei W3Schools">JavaScript</a> oder <a href="https://www.php.net" target="_blank" rel="noopener norefferer" title="Website über «Hypertext Preprocessor» (PHP)">PHP</a> gehört und wissen damit nur begrenzt, was sie tun.</p>
                                            
                                            <p>Ich bin der beste <?php echo $catchment['keyword'][1]; ?> für dich, wenn du eine Website benötigst, die perfekt zu deinem Unternehmen passt, weil ich sie speziell dafür entwickle. Sie wird gut von Suchmaschinen gefunden (SEO), hilft dir, neue Kunden zu gewinnen und bestehende zu binden und überzeugt durch Funktionen, die Sinn machen. Wie eine Sekretärin oder ein Sekretär könnte sie deine Kunden zum Beispiel darüber informieren, ob du gerade verfügbar bist oder nicht und, wenn deine Kunden dich anrufen, dafür sorgen, dass sie nur verbunden werden, wenn du es bist. Synchronisiert mit deinem Kalender und in Echtzeit. Wenn du es nicht bist, könnte sie deinen Kunden anbieten, einen Termin zu buchen. Schnittstellen zu <a href="https://www.calendly.com" target="_blank" rel="noopener noreferrer" title="Website von Calendly">Calendly</a>, <a href="https://www.twilio.com" target="_blank" rel="noopener noreferrer" title="Website von Twilio in San Francisco (Vereinigte Staaten)">Twilio</a>, <a href="https://www.getharvest.com" target="_blank" rel="noopener noreferrer" title="Website von Harvest in New York City (Vereinigte Staaten)">Harvest</a> und weiteren Lieferanten ermöglichen fast alles.</p>

                                            <p>Ob ich der beste <?php echo $catchment['title'][4][0]; ?> bin, interessiert mich nicht. Wie erwähnt, leisten viele meiner Kolleginnen und Kollegen hervorragende Arbeit. Mich interessiert, ob ich der beste für dich bin. Wollen wir uns bald kennenlernen und es herausfinden?</p>
                                        </div>
                                    </section>

                                    <?php
                                    require_once('content/about-me.php');

                                    echo '

                                        <section data-scroll-section>
                                            <div class="dd-exhibits">

                                    ';
                                }

                                if($index > 5) {
                                    break;
                                }
                            }
                            ?>

                            <?php /*
                            <div class="dd-exhibit-loader-wrapper" data-scroll>
                                <a class="dd-exhibit-loader dd-d-none" href="javascript:;">
                                    <?php echo file_get_contents('theme/public/assets/frontend/new/images/icon-arrow-down.svg'); ?>
                                </a>
                            </div>
                            */ ?>
                        </div>
                    </section>
                
                    <?php
                }
                
                /*
                if($catchment['data']) {
                    $catchment['data']['weather'] = $catchment['data']['type'] == 2 ? dischdev()->weather($catchment['data']['latitude'], $catchment['data']['longitude']) : null;
                    ?>

                    <section class="dd-min-h-0" data-scroll-section>
                        <div class="dd-container" data-scroll>
                            <table class="dd-table-catchment">
                                <tbody>
                                    
                                    <?php
                                    if($catchment['data']['type'] == 2) {
                                        if($catchment['city']['name']) {
                                            echo '

                                                <tr>
                                                    <td>' . ($catchment['state']['name'] ? 'Staat' : 'Land') . ':</td>
                                                    <td>' . ($catchment['city']['url'][1] ? $catchment['city']['url'][1] : $catchment['city']['name']) . '</td>
                                                </tr>

                                            ';
                                        }

                                        if($catchment['data']['capital']) {
                                            echo '

                                                <tr>
                                                    <td>Hauptort:</td>
                                                    <td>' . $catchment['data']['capital'] . '</td>
                                                </tr>

                                            ';
                                        }

                                        if($catchment['state']['name']) {
                                            echo '

                                                <tr>
                                                    <td>Land:</td>
                                                    <td>' . ($catchment['state']['url'][1] ? $catchment['state']['url'][1] : $catchment['state']['name']) . '</td>
                                                </tr>

                                            ';
                                        }

                                        if(!$catchment['state']['name'] && $catchment['data']['languages']) {
                                            echo '

                                                <tr>
                                                    <td>Sprachen:</td>
                                                    <td>' . $catchment['data']['languages'] . '</td>
                                                </tr>

                                            ';
                                        }

                                        if($catchment['data']['population']) {
                                            echo '

                                                <tr>
                                                    <td>Einwohner:</td>
                                                    <td>' . $catchment['data']['population'] . '</td>
                                                </tr>

                                            ';
                                        }

                                        if($catchment['data']['area']) {
                                            echo '

                                                <tr>
                                                    <td>Fläche:</td>
                                                    <td>' . $catchment['data']['area'] . '</td>
                                                </tr>

                                            ';
                                        }
                                    } else {
                                        if($catchment['city']['name']) {
                                            echo '

                                                <tr>
                                                    <td>Gemeinde:</td>
                                                    <td>' . $catchment['city']['name'] . '</td>
                                                </tr>

                                            ';
                                        }

                                        if($catchment['state']['name']) {
                                            echo '

                                                <tr>
                                                    <td>Staat:</td>
                                                    <td>' . $catchment['state']['name'] . '</td>
                                                </tr>

                                            ';
                                        }

                                        if($catchment['data']['region']) {
                                            echo '

                                                <tr>
                                                    <td>Region:</td>
                                                    <td>' . $catchment['data']['region'] . '</td>
                                                </tr>

                                            ';
                                        }

                                        if($catchment['data']['population']) {
                                            echo '

                                                <tr>
                                                    <td>Einwohner:</td>
                                                    <td>' . $catchment['data']['population'] . '</td>
                                                </tr>

                                            ';
                                        }
                                        
                                        if($catchment['data']['weather'] && array_key_exists('temperature', $catchment['data']['weather']) && $catchment['data']['weather']['temperature']) {
                                            echo '

                                                <tr>
                                                    <td>Wetter:</td>
                                                    <td>' . $catchment['data']['weather']['temperature'] . ' &deg;C</td>
                                                </tr>

                                            ';
                                        } else if($catchment['data']['area']) {
                                            echo '

                                                <tr>
                                                    <td>Fläche:</td>
                                                    <td>' . $catchment['data']['area'] . '</td>
                                                </tr>

                                            ';
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </section>

                    <?php
                }
                */
                ?>

                <section id="dd-section-opening" class="dd-min-h-0 dd-section-opening" data-scroll-section>
                    <div class="dd-container" data-scroll>
                        <h2 class="dd-tagline">Webanwendungen mit Schnittstellen zu Twilio und weiteren</h2>

                        <p class="dd-display-4">Mein Name ist Maik Disch. Ich bin ein <?php echo $catchment['title'][5][0]; ?> und entwickle neben klassischen Websites, die deine Produkte und ihre Vorteile präsentieren, auch Webanwendungen mit Schnittstellen zu <a href="https://www.calendly.com" target="_blank" rel="noopener noreferrer" title="Website von Calendly">Calendly</a>, <a href="https://www.twilio.com" target="_blank" rel="noopener noreferrer" title="Website von Twilio in San Francisco (Vereinigte Staaten)">Twilio</a>, <a href="https://www.getharvest.com" target="_blank" rel="noopener noreferrer" title="Website von Harvest in New York City (Vereinigte Staaten)">Harvest</a> und weiteren. Du brauchst aber nur ein Logo? Auch dann bist du bei mir richtig.</p>
                    </div>
                </section>

                <?php
                require_once('content/redaxo.php');
                require_once('content/partners.php');
                ?>

                <section id="dd-section-services" class="dd-min-h-0 dd-section-services" data-scroll-section>
                    <div class="dd-container" data-scroll>
                        <h2 class="dd-tagline"><?php echo $title[0]; ?></h2>

                        <?php
                        echo '<ul class="dd-display-4 dd-paragraph">';

                        foreach($services as $value) {
                            echo '<li>' . $value . '</li>';
                        }

                        echo '</ul>';
                        ?>
                    </div>
                </section>
                
                <?php
                require_once('content/contact.php');
                require_once('partials/copyright.php');
                ?>

                <footer data-scroll-section data-scroll-position="bottom">
                    <div data-scroll>
                        <?php echo dd_part()->background(); ?>
                    </div>
                </footer>

                <div id="dd-logo-footer-wrapper" class="dd-logo-footer-wrapper">
                    <a href="<?php echo rex_getUrl(1); ?>" title="Website von Maik Disch aus Malans (Graubünden)">
                        <?php echo dd_part()->logo(false, true, true); ?>
                    </a>
                </div>

                <?php
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
