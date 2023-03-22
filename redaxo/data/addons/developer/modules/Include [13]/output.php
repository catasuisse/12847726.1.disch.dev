<?php
if(rex::isFrontend()) {
    require_once(rex_path::base('theme/content/REX_VALUE[1].php'));
} else {
    ?>

    <code>content/REX_VALUE[1].php</code>

    <?php
}
