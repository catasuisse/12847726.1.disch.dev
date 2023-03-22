<?php

if(!$_POST || !array_key_exists('upload_token', $_POST)) {
    http_response_code(500);

    exit();
}

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

require_once('./inc/boot.php');

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

if(!array_key_exists('request', $_POST)) {
    $_POST['request'] = 'upload';
}

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

if($_POST['request'] == 'upload' && array_key_exists('file', $_FILES)) {

    echo json_encode(dd_disk::uploadFile($_FILES['file'], $_POST['upload_token']));

} else if($_POST['request'] == 'delete' && array_key_exists('file_name', $_POST)) {

    echo json_encode(dd_disk::deleteFile($_POST['file_name'], $_POST['upload_token']));

}
