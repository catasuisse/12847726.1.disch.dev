<?php
$values = rex_var::toArray('REX_VALUE[2]');
?>

<section class="dd-min-h-0" data-scroll-section>
    <div class="dd-container" data-scroll>
        <ul class="dd-h-consistent dd-list-archive dd-list-hero">
            <?php
            foreach($values as $value) {
                $fileSize = '–';
                $fileType = '–';

                if(file_exists('./media/' . $value['REX_MEDIA_1'])) {
                    $fileSize = dischdev()->bytes(filesize('./media/' . $value['REX_MEDIA_1']));
                    $fileType = strtoupper(pathinfo('./media/' . $value['REX_MEDIA_1'], PATHINFO_EXTENSION));
                }

                echo '

                    <li>
                        <a href="/media/' . $value['REX_MEDIA_1'] . '" data-fancybox>
                            <h3 class="dd-mb-0">' . ($value['title'] ? $value['title'] : $value['REX_MEDIA_1']) . '</h3>

                            <p class="dd-metadata">' . $fileType . ' – ' . $fileSize . '</p>
                        </a>
                    </li>

                ';
            }
            ?>
        </ul>
    </div>
</section>