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
        'alert' => 'Ihre Angaben wurden als Werbung eingestuft.',
        'code' => 2,
        'type' => 'danger',
    ];

    $feedback = json_encode($feedback);

    echo $feedback;

    exit();
}

$_POST['url'] = dd::fullUrl($_POST['article'], rex_getUrl($_POST['article']));

// rex_sql::factory()
//     ->setQuery('

//         INSERT INTO
//         dd_contact
//         SET
//         callname = :callname,
//         content = :content,
//         createdate = :createdate,
//         email = :email,
//         ip = :ip,
//         referer = :referer,
//         updatedate = :updatedate,
//         url = :url

//     ', [

//         'callname' => $_POST['callname'],
//         'content' => $_POST['content'],
//         'createdate' => date('Y-m-d H:i:s', time()),
//         'email' => $_POST['email'],
//         'ip' => $_SERVER['REMOTE_ADDR'],
//         'referer' => $_POST['referer'],
//         'updatedate' => date('Y-m-d H:i:s', time()),
//         'url' => $_POST['url'],

//     ]);

$message = '

    <p>Es gibt eine neue Nachricht von ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . ':</p>

    <p style="font-style: italic;">' . nl2br($_POST['content']) . '</p>

    <p style="font-weight: bold;">Kontaktdaten:</p>

    <ul>

        <li>Nachname: ' . $_POST['lastname'] . '</li>

        <li>Vorname: ' . $_POST['firstname'] . '</li>

        <li>E-Mail: ' . $_POST['email'] . '</li>

        <li>Telefon: ' . $_POST['telephone'] . '</li>

        <li>Strasse und Hausnummer: ' . $_POST['street'] . '</li>

        <li>Postleitzahl: ' . $_POST['postal_code'] . '</li>

        <li>Ort: ' . $_POST['city'] . '</li>

        <li>IP: ' . $_SERVER['REMOTE_ADDR'] . '</li>

        <li>Referer: ' . ($_POST['referer'] ? $_POST['referer'] : '–') . '</li>

        <li>URL: ' . ($_POST['url'] ? $_POST['url'] : '–') . '</li>

    </ul>

';

dd::mail(

    'help@disch.dev',

    'Test',

    $message,

    '',

    'admin',

    [$_POST['email'], $_POST['firstname'] . ' ' . $_POST['lastname']]

);

// $message = '

//     <p>Vielen Dank für Ihre Nachricht!</p>

// ';

// dd::mail(

//     $_POST['email'],

//     'Vielen Dank für Ihre Nachricht!',

//     $message,

//     null,

//     'admin'

// );

$feedback = [
    'alert' => 'Vielen Dank für Ihre Nachricht!',
    'code' => 1,
    'type' => 'success',
];

$feedback = json_encode($feedback);

echo $feedback;
