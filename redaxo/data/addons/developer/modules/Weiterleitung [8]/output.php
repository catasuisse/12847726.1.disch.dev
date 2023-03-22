<?php
$link = 'REX_LINK[1]';

if(rex::isFrontend()) {
    if($link && rex_article::get($link)) {
        dischdev()->redirect($link);
    } else if(rex_article::get(8)) {
        dischdev()->redirect(8);
    }
}
