<?php

sleep(3);

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

require_once('./inc/boot.php');

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

$exclude = dd_data::exclude([
    'ip' => $_SERVER['REMOTE_ADDR'],
]);

if($_POST['honeypot'] || $exclude) {
    if($exclude) {
        rex_sql::factory()
            ->setQuery('

                UPDATE
                dd_exclude
                SET
                updatedate = :updatedate
                WHERE
                ip = :ip

            ', [

                'ip' => $_SERVER['REMOTE_ADDR'],
                'updatedate' => date('Y-m-d H:i:s', time()),

            ]);
    } else {
        rex_sql::factory()
            ->setQuery('

                INSERT INTO
                dd_exclude
                SET
                createdate = :createdate,
                ip = :ip,
                updatedate = :updatedate

            ', [

                'createdate' => date('Y-m-d H:i:s', time()),
                'ip' => $_SERVER['REMOTE_ADDR'],
                'updatedate' => date('Y-m-d H:i:s', time()),

            ]);
    }

    $feedback = [
        'alert' => 'Deine Angaben wurden als Werbung eingestuft.',
        'code' => 2,
        'type' => 'danger',
    ];

    $feedback = json_encode($feedback);

    echo $feedback;

    exit();
}

$callname = $_POST['callname'];
$email = $_POST['email'];
$firstname = '';
$lastname = '';

if($_POST['email'] || $_POST['token']) {
    $receiver = dd_data::receiver([
        'email' => $_POST['email'],
        'token' => $_POST['token']
    ]);

    if($receiver) {
        $firstname = $receiver['firstname'];
        $lastname = $receiver['lastname'];

        if(!$callname) {
            $callname = $receiver['callname'];
        }

        if(!$email) {
            $email = $receiver['email'];
        }
    }
}

rex_set_session('callname', $_POST['callname']);
rex_set_session('email', $_POST['email']);
rex_set_session('notification', $_POST['notification']);

rex_sql::factory()
    ->setQuery('

        INSERT INTO
        dd_comment
        SET
        callname = :callname,
        content = :content,
        createdate = :createdate,
        email = :email,
        firstname = :firstname,
        ip = :ip,
        lastname = :lastname,
        notification = :notification,
        parent = :parent,
        post = :post,
        status = :status,
        token = :token,
        updatedate = :updatedate

    ', [

        'callname' => $callname,
        'content' => $_POST['content'],
        'createdate' => date('Y-m-d H:i:s', time()),
        'email' => $email,
        'firstname' => $firstname,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'lastname' => $lastname,
        'notification' => $_POST['notification'],
        'parent' => $_POST['parent'],
        'post' => $_POST['post'],
        'status' => 1,
        'token' => dd::token(),
        'updatedate' => date('Y-m-d H:i:s', time()),

    ]);

$comment = [];

$comment = rex_sql::factory()
    ->getArray('

        SELECT
        *
        FROM
        dd_comment
        ORDER BY
        id DESC
        LIMIT
        1

    ');

if(!$comment) {
    exit;
}

$comment = $comment[0];

$post = dd_post::get($comment['post']);

if($post) {
    $callname = $comment['callname'];
    $date = str_replace(', ', ' um ', dd::date(strtotime($comment['createdate'])));

    if(!$callname && $comment['firstname'] && $comment['lastname']) {
        $callname = $comment['firstname'] . ' ' . substr($comment['lastname'], 0, 1) . '.';
    }

    $message = '

        <p>' . $callname . ' hat am ' . $date . ' einen Kommentar zu deinem Beitrag «' . $post['title'] . '» hinterlassen:</p>

        <p style="font-style: italic;">' . nl2br($comment['content']) . '</p>

        <p style="font-weight: bold;">Kontaktdaten:</p>

        <ul>

            <li>ID: ' . $comment['id'] . '</li>

            <li>Nachname: ' . $comment['lastname'] . '</li>

            <li>Vorname: ' . $comment['firstname'] . '</li>

            <li>Rufname: ' . $comment['callname'] . '</li>

            <li>E-Mail: ' . $comment['email'] . '</li>

            <li>Datum: ' . $comment['createdate'] . '</li>

            <li>IP: ' . $comment['ip'] . '</li>

        </ul>

    ';

    dd::mail(

        dd::settings('contact', 'email'),

        'Neuer Kommentar von ' . $callname,

        $message

    );
}

$feedback = [
    'alert' => 'Deine Angaben wurden erfolgreich gesendet.',
    'code' => 1,
    'comment' => str_pad($comment['id'], 6, 0, STR_PAD_LEFT),
    'type' => 'success',
];

$feedback = json_encode($feedback);

echo $feedback;
