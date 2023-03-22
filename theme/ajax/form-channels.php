<?php

require_once('./inc/boot.php');

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

$receiver = dd_data::receiver([
    'token' => $_POST['token'],
]);

if(!$receiver) {
    $feedback = [
        'alert' => 'Deine Angaben wurden als Werbung eingestuft.',
        'code' => 2,
        'type' => 'danger',
    ];

    $feedback = json_encode($feedback);

    echo $feedback;

    exit();
}

$channels = $receiver['channels'];

if($_POST['email']) {
    $channels = dd::addToList(1, $channels);
} else {
    $channels = dd::removeFromList(1, $channels);
}

if($_POST['sms']) {
    $channels = dd::addToList(2, $channels);
} else {
    $channels = dd::removeFromList(2, $channels);
}

rex_sql::factory()
    ->setQuery('

        UPDATE
        dd_receiver
        SET
        channels = :channels
        WHERE
        id = :id

    ', [

        'channels' => $channels,
        'id' => $receiver['id'],

    ]);

$feedback = [
    'alert' => 'Deine Angaben wurden erfolgreich gesendet.',
    'code' => 1,
    'type' => 'success',
];

$feedback = json_encode($feedback);

echo $feedback;
