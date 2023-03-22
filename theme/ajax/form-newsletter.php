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
    'email' => $_POST['email'],
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
                identifier = :identifier
                OR
                ip = :ip

            ', [

                'identifier' => $_POST['email'],
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
                identifier = :identifier,
                ip = :ip,
                updatedate = :updatedate

            ', [

                'createdate' => date('Y-m-d H:i:s', time()),
                'identifier' => $_POST['email'],
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

$receiver = dd_data::receiver(['email' => $_POST['email']]);

if($receiver && !$receiver['status']) {
    $feedback = [
        'alert' => 'Deine Angaben wurden als Werbung eingestuft.',
        'code' => 3,
        'type' => 'danger',
    ];

    $feedback = json_encode($feedback);

    echo $feedback;

    exit();
}

$follower = dd_data::follower(['email' => $_POST['email']]);

if($follower && $follower['status']) {
    $feedback = [
        'alert' => 'Du bist bereits angemeldet.',
        'code' => 4,
        'type' => 'danger',
    ];

    $feedback = json_encode($feedback);

    echo $feedback;

    exit();
}

$prospect = dd_data::prospect(['email' => $_POST['email']]);

if($prospect) {
    $token = $prospect['token'];

    rex_sql::factory()
        ->setQuery('

            UPDATE
            dd_prospect
            SET
            callname = :callname,
            updatedate = :updatedate
            WHERE
            token = :token

        ', [

            'callname' => $_POST['callname'],
            'token' => $token,
            'updatedate' => date('Y-m-d H:i:s', time()),

        ]);
} else {
    $token = dd::token();

    rex_sql::factory()
        ->setQuery('

            INSERT INTO
            dd_prospect
            SET
            callname = :callname,
            createdate = :createdate,
            email = :email,
            token = :token,
            updatedate = :updatedate

        ', [

            'callname' => $_POST['callname'],
            'createdate' => date('Y-m-d H:i:s', time()),
            'email' => $_POST['email'],
            'token' => $token,
            'updatedate' => date('Y-m-d H:i:s', time()),

        ]);
}

$url = dd::fullUrl(26, rex_getUrl(26, '', ['token' => dd::formatedToken($token)]));

$message = '

    <p>Hallo ' . $_POST['callname'] . '</p>

    <p>Öffne bitte den folgenden Link, um deine Angaben zu verifizieren:</p>

    <p><a href="' . $url . '" target="_blank">' . $url . '</a></p>

';

dd::mail(

    $_POST['email'],

    'Verifizierung deiner Angaben',

    $message

);

$feedback = [
    'alert' => 'Du solltest gleich eine E-Mail von mir erhalten. Folge bitte den darin enthaltenen Anweisungen, um den Prozess abzuschliessen!',
    'code' => 1,
    'type' => 'success',
];

$feedback = json_encode($feedback);

echo $feedback;
