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
    'identifier' => $_POST['identifier'],
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

                'identifier' => $_POST['identifier'],
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
                'email' => $_POST['identifier'],
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

$receiver = dd_data::receiver(['email' => $_POST['identifier']]);

if(!$receiver) {
    $receiver = dd_data::receiver(['harvest_id' => $_POST['identifier']]);
}

if(!$receiver || ($receiver && !$receiver['status'])) {
    $feedback = [
        'alert' => 'Deine Angaben wurden als Werbung eingestuft.',
        'code' => 4,
        'type' => 'danger',
    ];

    $feedback = json_encode($feedback);

    echo $feedback;

    exit();
}

if($_POST['post']) {
    $permission = dd::permission(null, $_POST['post'], $receiver['token']);

    $_POST['article'] = 24;
} else {
    $permission = dd::permission($_POST['article'], null, $receiver['token']);
}

if(!$permission) {
    $feedback = [
        'alert' => 'Dir fehlt die Berechtigung für diesen Bereich.',
        'code' => 3,
        'type' => 'danger',
    ];

    $feedback = json_encode($feedback);

    echo $feedback;

    exit();
}

if($_POST['post']) {
    $article = dd_data::post($_POST['post']);

    $articleName = $article['title'];
    $url = dd::fullUrl($_POST['article'], rex_getUrl('', '', ['post_id' => $article['id'], 'token' => dd::formatedToken($receiver['token'])]));
} else {
    $article = rex_article::get($_POST['article']);

    $articleName = $article->getValue('name');
    $url = dd::fullUrl($_POST['article'], rex_getUrl($_POST['article'], '', ['token' => dd::formatedToken($receiver['token'])]));
}

$message = '

    <p>Hallo ' . ($receiver['callname'] ? $receiver['callname'] : $receiver['firstname']) . '</p>

    <p>Dein persönlicher Link für den Bereich «' . $articleName . '» lautet:</p>

    <p><a href="' . $url . '" target="_blank">' . $url . '</a></p>

';

dd::mail(

    $receiver['email'],

    'Persönlicher Link für den Bereich «' . $articleName . '»',

    $message

);

$feedback = [
    'alert' => 'Du solltest gleich eine E-Mail von mir erhalten. Folge bitte den darin enthaltenen Anweisungen, um den Prozess abzuschliessen!',
    'code' => 1,
    'type' => 'success',
];

$feedback = json_encode($feedback);

echo $feedback;
