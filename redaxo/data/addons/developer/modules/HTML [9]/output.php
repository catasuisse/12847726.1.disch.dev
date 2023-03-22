<?php
if(rex::isFrontend()) {
    ?>

    REX_VALUE[id=1 output=html]

    <?php
} else {
    ?>

    <code>REX_VALUE[1]</code>

    <?php
}
