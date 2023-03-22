<?php

$fileNames = dd_disk::directoryContent(dd_disk::path());

if(!$fileNames) {
    // Is correct here, because otherwise an error is written into the log:
    return true;
}

foreach($fileNames as $value) {
    $filePath = dd_disk::path($value);

    if(is_dir($filePath) && filemtime($filePath) < time() - 86400) {
        dd_disk::deleteDirectory($filePath);
    }
}

return true;