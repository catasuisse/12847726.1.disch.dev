<?php
$token = dd::unformatedToken(rex_get('token'));

if(!$token) {
    dischdev()->redirect(6);
}

$prospect = dd_data()->prospect(['token' => $token]);

if(!$prospect) {
    dischdev()->redirect(6);
}

$receiver = dd_data()->receiver(['email' => $prospect['email']]);

if($receiver) {
    $audiences = dischdev()->addToList([2], $receiver['audiences']);

    rex_sql::factory()
        ->setQuery('

            UPDATE
            dd_receiver
            SET
            audiences = :audiences,
            callname = :callname
            WHERE
            id = :id

        ', [

            'audiences' => $audiences,
            'callname' => $prospect['callname'],
            'id' => $receiver['id'],


        ]);
} else {
    rex_sql::factory()
        ->setQuery('

            INSERT INTO
            dd_receiver
            SET
            audiences = :audiences,
            callname = :callname,
            channels = :channels,
            companies = :companies,
            content = :content,
            createdate = :createdate,
            email = :email,
            firstname = :firstname,
            harvest_id = :harvest_id,
            lastname = :lastname,
            relation = :relation,
            status = :status,
            telephone = :telephone,
            token = :token,
            updatedate = :updatedate

        ', [

            'audiences' => 2,
            'callname' => $prospect['callname'],
            'channels' => '1,2',
            'companies' => '',
            'content' => '',
            'createdate' => date('Y-m-d H:i:s', time()),
            'email' => $prospect['email'],
            'firstname' => '',
            'harvest_id' => '',
            'lastname' => '',
            'relation' => '',
            'status' => 1,
            'telephone' => '',
            'token' => dischdev()->token(),
            'updatedate' => date('Y-m-d H:i:s', time()),

        ]);
}

$receiver = rex_sql::factory()
    ->getArray('

        SELECT
        *
        FROM
        dd_receiver
        WHERE
        email = :email

    ', [

        'email' => $prospect['email'],

    ]);

if(!$receiver) {
    dischdev()->redirect(6);
}

$receiver = $receiver[0];

rex_unset_session('token');

rex_set_session('token', $receiver['token']);

rex_sql::factory()
    ->setQuery('

        DELETE FROM
        dd_prospect
        WHERE
        id = :id

    ', [

        'id' => $prospect['id'],

    ]);

$message = '

    <p>Hallo ' . ($receiver['callname'] ? $receiver['callname'] : $receiver['firstname']) . '</p>

    <p>Es freut mich sehr, dass du meinen Newsletter abonniert hast, dich damit für mein Leben als digitaler Nomade zu interessieren scheinst und mich virtuell auf meinen Reisen begleiten möchtest.</p>

    <p>Hier findest du den letzten Beitrag:</p>

';

$index = 0;

foreach(dd_data()->posts(2) as $value) {
    if(!$value['content_original']) {
        continue;
    }

    $url = dd::fullUrl(24, rex_getUrl('', '', ['post_id' => $value['id'], 'token' => dd::formatedToken($receiver['token'])]));

    $message .= '

        <p><a href="' . $url . '" target="_blank">' . $url . '</a></p>

    ';

    $index++;

    if($index > 0) {
        break;
    }
}

dischdev()->mail(

    $receiver['email'],

    'Willkommen in meinem inneren Kreis!',

    $message

);

$message = '

    <p>Es gibt einen neuen Empfänger für den Newsletter:</p>

    <ul>

        <li>Rufname: ' . $receiver['callname'] . '</li>

        <li>E-Mail: ' . $receiver['email'] . '</li>

    </ul>

';

dischdev()->mail(

    dd::settings('contact', 'email'),

    'Neuer Empfänger für den Newsletter',

    $message,

    null,

    'admin',

    $prospect['email']

);
?>

<section data-scroll-section>
    <div class="dd-container" data-scroll data-scroll-position="top">
        <p class="dd-text-success">Deine Angaben wurden verifiziert und du wurdest angemeldet.</p>
    </div>
</section>
