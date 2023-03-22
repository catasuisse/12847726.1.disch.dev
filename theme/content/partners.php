<?php
$partners = dd_data()->partners();
?>

<section id="dd-section-partners" class="dd-min-h-0 dd-section-partners" data-scroll-section>
    <div class="dd-container" data-scroll>
        <div class="dd-partner-source">
            <?php
            foreach($partners as $value) {
                echo '<img src="/partners/' . $value['filename'] . '/' . $value['filename'] . '.svg" alt="' . $value['title'] . '" title="' . $value['title'] . '" />';
            }

            shuffle($partners);
            ?>
        </div>

        <div class="dd-partners">
            <?php
            $x = isset($index) ? $index : 0;

            $index = 0;

            foreach($partners as $value) {
                echo '
                
                    <div class="dd-partner">
                        <div>
                            <img src="/partners/' . $value['filename'] . '/' . $value['filename'] . '.svg" alt="' . $value['title'] . '" title="' . $value['title'] . '" />
                            <img src="" alt="" title="" style="display: none;" />
                        </div>
                    </div>
                
                ';

                $index++;

                if($index > 5) {
                    break;
                }
            }

            $index = $x;
            ?>
        </div>
    </div>
</section>
