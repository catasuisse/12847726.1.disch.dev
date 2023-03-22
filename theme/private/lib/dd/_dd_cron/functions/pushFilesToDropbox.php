<?php

$push = dd_api::push('dropbox', 'files');

if(!$push) {
    // Is correct here, because otherwise an error is written into the log:
    return true;
}

return true;