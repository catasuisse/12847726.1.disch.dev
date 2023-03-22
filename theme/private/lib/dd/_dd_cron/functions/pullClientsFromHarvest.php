<?php

$receivers = dd_api::pull('harvest', 'clients');

if(!$receivers) {
    return true;
}

$emails = array_column($receivers, 'email');
$followers = dd_data::followers(true);
$friends = dd_data::friends(true);
$harvestIds = array_column($receivers, 'id');

$followers = array_column($followers, 'id');
$friends = array_column($friends, 'id');

$query = '

    DELETE FROM
    dd_receiver
    WHERE
    harvest_id != ""

';

if($emails) {
    $query .= '

        AND
        email NOT IN (' . rex_sql::factory()->in($emails) . ')

    ';
}

if($friends) {
    $query .= '

        AND
        id NOT IN (' . rex_sql::factory()->in($friends) . ')

    ';
}

if($followers) {
    $query .= '

        AND
        id NOT IN (' . rex_sql::factory()->in($followers) . ')

    ';
}

if($harvestIds) {
    $query .= '

        AND
        harvest_id NOT IN (' . rex_sql::factory()->in($harvestIds) . ')

    ';
}

rex_sql::factory()->setQuery($query);

$query = '

    SELECT
    *
    FROM
    dd_receiver
    WHERE
    id > 0

';

if($emails) {
    $query .= '

        AND
        email NOT IN (' . rex_sql::factory()->in($emails) . ')

    ';
}

if($harvestIds) {
    $query .= '

        AND
        harvest_id NOT IN (' . rex_sql::factory()->in($harvestIds) . ')

    ';
}

$excludes = rex_sql::factory()->getArray($query);

foreach($excludes as $value) {
    $audiences = dd::removeFromList(3, $value['audiences']);

    rex_sql::factory()
        ->setQuery('

            UPDATE
            dd_receiver
            SET
            audiences = :audiences,
            duplicates = :duplicates,
            harvest_id = :harvest_id
            WHERE
            id = :id

        ', [

            'audiences' => $audiences,
            'duplicates' => '',
            'harvest_id' => '',
            'id' => $value['id'],

        ]);
}

if($receivers) {
    foreach($receivers as $value) {
        $token = [];

        $receiver = rex_sql::factory()
            ->getArray('

                SELECT
                *
                FROM
                dd_receiver
                WHERE
                email = :email
                OR
                harvest_id = :harvest_id

            ', [

                'email' => $value['email'],
                'harvest_id' => $value['id'],

            ]);

        if($receiver) {
            $receiver = $receiver[0];

            $audiences = dd::addToList(3, $receiver['audiences']);

            rex_sql::factory()
                ->setQuery('

                    UPDATE
                    dd_receiver
                    SET
                    audiences = :audiences,
                    companies = :companies,
                    duplicates = :duplicates,
                    email = :email,
                    firstname = :firstname,
                    harvest_id = :harvest_id,
                    lastname = :lastname,
                    telephone = :telephone,
                    updatedate = :updatedate
                    WHERE
                    id = :id

                ', [

                    'audiences' => $audiences,
                    'companies' => $value['companies'],
                    'duplicates' => $value['duplicates'],
                    'email' => $value['email'],
                    'firstname' => $value['firstname'],
                    'harvest_id' => $value['id'],
                    'id' => $receiver['id'],
                    'lastname' => $value['lastname'],
                    'telephone' => str_replace(' ', '', $value['telephone']),
                    'updatedate' => date('Y-m-d H:i:s', time()),

                ]);

            rex_sql::factory()
                ->setQuery('

                    UPDATE
                    dd_comment
                    SET
                    email = :email_new,
                    firstname = :firstname,
                    lastname = :lastname
                    WHERE
                    email = :email_old

                ', [

                    'email_new' => $value['email'],
                    'email_old' => $receiver['email'],
                    'firstname' => $value['firstname'],
                    'lastname' => $value['lastname'],

                ]);
        } else {
            $token[] = dd::token();

            rex_sql::factory()
                ->setQuery('

                    INSERT INTO
                    dd_receiver
                    SET
                    audiences = :audiences,
                    channels = :channels,
                    companies = :companies,
                    createdate = :createdate,
                    duplicates = :duplicates,
                    email = :email,
                    firstname = :firstname,
                    harvest_id = :harvest_id,
                    lastname = :lastname,
                    status = :status,
                    telephone = :telephone,
                    token = :token,
                    updatedate = :updatedate

                ', [

                    'audiences' => '3',
                    'channels' => '1,2',
                    'companies' => $value['companies'],
                    'createdate' => date('Y-m-d H:i:s', time()),
                    'duplicates' => $value['duplicates'],
                    'email' => $value['email'],
                    'firstname' => $value['firstname'],
                    'harvest_id' => $value['id'],
                    'lastname' => $value['lastname'],
                    'status' => 1,
                    'telephone' => str_replace(' ', '', $value['telephone']),
                    'token' => $token[0],
                    'updatedate' => date('Y-m-d H:i:s', time()),

                ]);

            // $prospect = dd_data::prospect(['email' => $value['email']]);

            // if($prospect) {
            //     $token[] = $prospect['token'];

            //     rex_sql::factory()
            //         ->setQuery('

            //             UPDATE
            //             dd_prospect
            //             SET
            //             callname = :callname,
            //             updatedate = :updatedate
            //             WHERE
            //             token = :token

            //         ', [

            //             'callname' => $value['firstname'] . ' ' . $value['lastname'],
            //             'token' => $token[1],
            //             'updatedate' => date('Y-m-d H:i:s', time()),

            //         ]);
            // } else {
            //     $token[] = dd::token();

            //     rex_sql::factory()
            //         ->setQuery('

            //             INSERT INTO
            //             dd_prospect
            //             SET
            //             callname = :callname,
            //             createdate = :createdate,
            //             email = :email,
            //             token = :token,
            //             updatedate = :updatedate

            //         ', [

            //             'callname' => $value['firstname'] . ' ' . $value['lastname'],
            //             'createdate' => date('Y-m-d H:i:s', time()),
            //             'email' => $value['email'],
            //             'token' => $token[1],
            //             'updatedate' => date('Y-m-d H:i:s', time()),

            //         ]);
            // }

            // $url = [
            //     dd::fullUrl(26, rex_getUrl(26, null, ['token' => dd::formatedToken($token[1])])),
            //     dd::fullUrl(32, rex_getUrl(32, null, ['token' => dd::formatedToken($token[0])])),
            // ];

            // $message = '

            //     <p>Hallo Maik</p>

            //     <p>Es freut mich sehr, dass du dich für mich entschieden hast und ich dich ab jetzt zu meinen Kunden zählen bzw. dir bald eine Offerte zukommen lassen darf! In dieser E-Mail findest du Informationen über das weitere Vorgehen und mich selbst.</p>

            //     <hr />

            //     <p><b></b></p>

            //     <p>&nbsp;</p>

            //     <p><a href="' . $url[1] . '" target="_blank">' . $url[1] . '</a></p>

            //     <hr />

            //     <p><b>Unser erstes Gespräch</b></p>

            //     <p>&nbsp;</p>

            //     <p><a href="' . $url[1] . '" target="_blank">' . $url[1] . '</a></p>

            //     <hr />

            //     <p><b>Vom Leben als digitaler Nomade</b></p>

            //     <p>Wie du vielleicht weisst, reise ich seit 2019 als digitaler Nomade um die Welt. Alles, was ich noch besitze, passt in einen Rucksack. Und der passt unter den Vordersitz in einem Flugzeug. In meinem Newsletter erzähle ich davon.</p>

            //     <p>Unter dem folgenden Link kannst du ihn abonnieren:</p>

            //     <p><a href="' . $url[0] . '" target="_blank">' . $url[0] . '</a></p>

            //     <hr />

            // ';

            // $message = '

            //     <p>Hallo ' . $value['firstname'] . '</p>

            //     <p>Es freut mich sehr, dass du dich für mich entschieden hast und ich dich ab jetzt zu meinen Kunden zählen darf!</p>

            //     <p>Wie du vielleicht weisst, reise ich seit 2019 als digitaler Nomade um die Welt. Alles, was ich noch besitze, passt in einen Rucksack. Und der passt unter den Vordersitz in einem Flugzeug.</p>

            //     <p>In meinem Newsletter erzähle ich davon.</p>

            //     <p>Wenn du ihn abonnieren und mich virtuell auf meinen Reisen begleiten möchtest, öffne bitte den folgenden Link:</p>

            //     <p><a href="' . $url[0] . '" target="_blank">' . $url[0] . '</a></p>

            // ';

            // dd::mail(

            //     $value['email'],

            //     'Willkommen bei Disch Development!',

            //     $message,

            //     null,

            //     null,

            //     null,

            //     true

            // );
        }
    }

    dd_sql::reindex([
        'dd_prospect',
        'dd_receiver'
    ]);
}

return true;