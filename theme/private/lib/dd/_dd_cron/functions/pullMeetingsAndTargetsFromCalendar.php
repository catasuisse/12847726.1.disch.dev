<?php

$meetingsAndTargets = dd_api::pull('calendar', 'meetings_targets');

if(!$meetingsAndTargets) {
    return true;
}

$lastUpdate = 0;
$meetings = $meetingsAndTargets['meetings'];
$targets = $meetingsAndTargets['targets'];

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

if($meetings) {
    usort($meetings, function($a, $b): int {
        return
            (strtotime($b['last_modified_array'][1]) <=> strtotime($a['last_modified_array'][1]));
    });

    $lastUpdate = strtotime($meetings[0]['last_modified_array'][1]) > $lastUpdate ? strtotime($meetings[0]['last_modified_array'][1]) : $lastUpdate;
}

if($targets) {
    usort($targets, function($a, $b): int {
        return
            (strtotime($b['last_modified_array'][1]) <=> strtotime($a['last_modified_array'][1]));
    });

    $lastUpdate = strtotime($targets[0]['last_modified_array'][1]) > $lastUpdate ? strtotime($targets[0]['last_modified_array'][1]) : $lastUpdate;
}

if($lastUpdate > time() - 600) {
    return true;
}

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

$query = '

    DELETE FROM
    dd_meeting
    WHERE
    calendar_id != ""

';

$calendarIds = [];

if($meetings) {
    foreach($meetings as $value) {
        $calendarIds[] = $value['uid'];
    }
}

if($calendarIds) {
    $query .= '

        AND
        calendar_id NOT IN (' . rex_sql::factory()->in($calendarIds) . ')

    ';
}

rex_sql::factory()->setQuery($query);

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

$query = '

    DELETE FROM
    dd_target
    WHERE
    calendar_id != ""

';

$calendarIds = [];

if($targets) {
    foreach($targets as $value) {
        $calendarIds[] = $value['uid'];
    }
}

if($calendarIds) {
    $query .= '

        AND
        calendar_id NOT IN (' . rex_sql::factory()->in($calendarIds) . ')

    ';
}

rex_sql::factory()->setQuery($query);

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

if($meetings || $targets) {
    $exception = dd_data::exception();
    $updates = [];
    $value = [];

    if($meetings) {
        foreach($meetings as $value[0]) {
            if(
                $exception['sickness'] &&
                !in_array($value[0]['location'], ['erledigt', 'pausiert']) &&
                $value[0]['dtstart_array'][2] <= time() + 86400 &&
                $value[0]['dtend_array'][2] - 1 > time()
            ) {
                $value[0]['location'] = 'storniert';
            }

            if(
                !in_array($value[0]['location'], ['pausiert', 'verspätet', 'wartend']) &&
                $value[0]['dtstart_array'][2] <= time() - 86400 * 7
            ) {
                rex_sql::factory()->setQuery('

                    DELETE FROM
                    dd_meeting
                    WHERE
                    calendar_id = :calendar_id

                ', [

                    'calendar_id' => $value[0]['uid'],

                ]);

                continue;
            }

            $clients = dd::tags($value[0]['description'], '@@');

            if(!$clients) {
                continue;
            }

            $content = dd::removeTags($value[0]['description'], ['@@', '##']);
            $description = str_replace(' *', '', $value[0]['summary']);
            $tags = dd::tags($value[0]['description'], '##');

            $description = trim($description);

            if(
                $exception['sickness'] &&
                !in_array($value[0]['location'], ['erledigt', 'pausiert']) &&
                $value[0]['dtstart_array'][2] <= time() + 86400 &&
                $value[0]['dtend_array'][2] - 1 > time()
            ) {
                $content = 'Ich bin krank und arbeite darum im Moment nicht. Ich melde mich gerne wieder, wenn ich wieder gesund bin.';
            }

            $meeting = rex_sql::factory()
                ->getArray('

                    SELECT
                    *
                    FROM
                    dd_meeting
                    WHERE
                    calendar_id = "' . $value[0]['uid'] . '"

                ');

            if($meeting) {
                $meeting = $meeting[0];

                rex_sql::factory()
                    ->setQuery('

                        UPDATE
                        dd_meeting
                        SET
                        clients = :clients,
                        content = :content,
                        description = :description,
                        details = :details,
                        enddate = :enddate,
                        startdate = :startdate,
                        tags = :tags,
                        updatedate = :updatedate
                        WHERE
                        id = :id

                    ', [

                        'clients' => implode(',', $clients) ?? '',
                        'content' => $content ?? '',
                        'description' => $description ?? '',
                        'details' => $value[0]['location'] ?? '',
                        'enddate' => date('Y-m-d H:i:s', $value[0]['dtend_array'][2] - 1),
                        'id' => $meeting['id'],
                        'startdate' => date('Y-m-d H:i:s', $value[0]['dtstart_array'][2]),
                        'tags' => implode(',', $tags) ?? '',
                        'updatedate' => date('Y-m-d H:i:s', time()),

                    ]);

                if(
                    (
                        $value[0]['location'] != $meeting['details'] &&
                        (
                            in_array($value[0]['location'], ['', 'pausiert', 'storniert', 'wartend']) ||
                            in_array($meeting['details'], ['', 'pausiert', 'storniert', 'wartend'])
                        )
                    ) ||
                    (
                        !$value[0]['location'] &&
                        $value[0]['dtstart_array'][2] > time() - 900 &&
                        $value[0]['dtstart_array'][2] != strtotime($meeting['startdate'])
                    )
                ) {
                    rex_sql::factory()
                        ->setQuery('

                            UPDATE
                            dd_meeting
                            SET
                            alertdate = :alertdate
                            WHERE
                            id = :id

                        ', [

                            'alertdate' => date('Y-m-d H:i:s', time()),
                            'id' => $meeting['id'],

                        ]);

                    if(
                        !str_contains($value[0]['description'], '##hidden') &&
                        !str_contains($value[0]['description'], '##muted') &&
                        $value[0]['location'] != 'erledigt'
                    ) {
                        foreach($clients as $value[1]) {
                            if(!array_key_exists($value[1], $updates)) {
                                $updates[$value[1]] = [];
                            }

                            $updates[$value[1]][] = [
                                'values_new' => [
                                    'alertdate' => date('Y-m-d H:i:s', time()),
                                    'content' => $content ?? '',
                                    'description' => $description ?? '',
                                    'details' => $value[0]['location'] ?? '',
                                    'enddate' => date('Y-m-d H:i:s', $value[0]['dtend_array'][2] - 1),
                                    'startdate' => date('Y-m-d H:i:s', $value[0]['dtstart_array'][2]),
                                    'category' => 'meeting',
                                ],
                                'values_old' => [
                                    'alertdate' => $meeting['alertdate'],
                                    'content' => $meeting['content'],
                                    'description' => $meeting['description'],
                                    'details' => $meeting['details'],
                                    'enddate' => $meeting['enddate'],
                                    'startdate' => $meeting['startdate'],
                                    'category' => 'meeting',
                                ],
                            ];
                        }
                    }
                }
            } else {
                rex_sql::factory()
                    ->setQuery('

                        INSERT INTO
                        dd_meeting
                        SET
                        alertdate = :alertdate,
                        calendar_id = :calendar_id,
                        clients = :clients,
                        content = :content,
                        createdate = :createdate,
                        description = :description,
                        details = :details,
                        enddate = :enddate,
                        startdate = :startdate,
                        status = :status,
                        tags = :tags,
                        updatedate = :updatedate

                    ', [

                        'alertdate' => date('Y-m-d H:i:s', time()),
                        'calendar_id' => $value[0]['uid'],
                        'clients' => implode(',', $clients) ?? '',
                        'content' => $content ?? '',
                        'createdate' => date('Y-m-d H:i:s', time()),
                        'description' => $description ?? '',
                        'details' => $value[0]['location'] ?? '',
                        'enddate' => date('Y-m-d H:i:s', $value[0]['dtend_array'][2] - 1),
                        'startdate' => date('Y-m-d H:i:s', $value[0]['dtstart_array'][2]),
                        'status' => 1,
                        'tags' => implode(',', $tags) ?? '',
                        'updatedate' => date('Y-m-d H:i:s', time()),

                    ]);

                if(
                    !str_contains($value[0]['description'], '##hidden') &&
                    !str_contains($value[0]['description'], '##muted') &&
                    $value[0]['location'] != 'erledigt' &&
                    (
                        in_array($value[0]['location'], ['pausiert', 'storniert', 'wartend']) ||
                        (
                            !$value[0]['location'] &&
                            $value[0]['dtstart_array'][2] > time() - 900
                        )
                    )
                ) {
                    foreach($clients as $value[1]) {
                        if(!array_key_exists($value[1], $updates)) {
                            $updates[$value[1]] = [];
                        }

                        $updates[$value[1]][] = [
                            'values_new' => [
                                'alertdate' => date('Y-m-d H:i:s', time()),
                                'content' => $content ?? '',
                                'description' => $description ?? '',
                                'details' => $value[0]['location'] ?? '',
                                'enddate' => date('Y-m-d H:i:s', $value[0]['dtend_array'][2] - 1),
                                'startdate' => date('Y-m-d H:i:s', $value[0]['dtstart_array'][2]),
                                'category' => 'meeting',
                            ],
                            'values_old' => [
                                'alertdate' => '',
                                'content' => '',
                                'description' => '',
                                'details' => '',
                                'enddate' => '',
                                'startdate' => '',
                                'category' => '',
                            ],
                        ];
                    }
                }
            }
        }

        dd_sql::reindex('dd_meeting');
    }

    if($targets) {
        foreach($targets as $value[0]) {
            if(
                $exception['sickness'] &&
                !in_array($value[0]['location'], ['erledigt', 'storniert'])
            ) {
                $value[0]['location'] = 'pausiert';
            } else if(
                !$value[0]['location'] &&
                $value[0]['dtend_array'][2] - 1 < time()
            ) {
                $value[0]['location'] = 'verspätet';
            }

            if(
                !in_array($value[0]['location'], ['pausiert', 'verspätet', 'wartend']) &&
                $value[0]['dtend_array'][2] - 1 <= time() - 86400 * 7
            ) {
                rex_sql::factory()->setQuery('

                    DELETE FROM
                    dd_target
                    WHERE
                    calendar_id = :calendar_id

                ', [

                    'calendar_id' => $value[0]['uid'],

                ]);

                continue;
            }

            $clients = dd::tags($value[0]['description'], '@@');

            if(!$clients) {
                continue;
            }

            $content = dd::removeTags($value[0]['description'], ['@@', '##']);
            $description = str_replace(' *', '', $value[0]['summary']);
            $tags = dd::tags($value[0]['description'], '##');

            $description = trim($description);

            if(
                $exception['sickness'] &&
                !in_array($value[0]['location'], ['erledigt', 'storniert'])
            ) {
                $content = 'Ich bin krank und arbeite darum im Moment nicht. Ich melde mich gerne wieder, wenn ich wieder gesund bin.';
            }

            $target = rex_sql::factory()
                ->getArray('

                    SELECT
                    *
                    FROM
                    dd_target
                    WHERE
                    calendar_id = "' . $value[0]['uid'] . '"

                ');

            if($target) {
                $target = $target[0];

                rex_sql::factory()
                    ->setQuery('

                        UPDATE
                        dd_target
                        SET
                        clients = :clients,
                        content = :content,
                        description = :description,
                        details = :details,
                        enddate = :enddate,
                        startdate = :startdate,
                        tags = :tags,
                        updatedate = :updatedate
                        WHERE
                        id = :id

                    ', [

                        'clients' => implode(',', $clients) ?? '',
                        'content' => $content ?? '',
                        'description' => $description ?? '',
                        'details' => $value[0]['location'] ?? '',
                        'enddate' => date('Y-m-d H:i:s', $value[0]['dtend_array'][2] - 1),
                        'id' => $target['id'],
                        'startdate' => date('Y-m-d H:i:s', $value[0]['dtstart_array'][2]),
                        'tags' => implode(',', $tags) ?? '',
                        'updatedate' => date('Y-m-d H:i:s', time()),

                    ]);

                if(
                    (
                        $value[0]['location'] != $target['details'] &&
                        (
                            in_array($value[0]['location'], ['', 'erledigt', 'pausiert', 'storniert', 'verspätet', 'wartend']) ||
                            in_array($target['details'], ['', 'erledigt', 'pausiert', 'storniert', 'verspätet', 'wartend'])
                        )
                    ) ||
                    (
                        !$value[0]['location'] &&
                        $value[0]['dtend_array'][2] > time() &&
                        $value[0]['dtend_array'][2] - 1 > strtotime($target['alertdate']) + 43200
                    )
                ) {
                    rex_sql::factory()
                        ->setQuery('

                            UPDATE
                            dd_target
                            SET
                            alertdate = :alertdate
                            WHERE
                            id = :id

                        ', [

                            'alertdate' => date('Y-m-d H:i:s', $value[0]['dtend_array'][2] - 1),
                            'id' => $target['id'],

                        ]);

                    if(
                        !str_contains($value[0]['description'], '##hidden') &&
                        !str_contains($value[0]['description'], '##muted')
                    ) {
                        foreach($clients as $value[1]) {
                            if(!array_key_exists($value[1], $updates)) {
                                $updates[$value[1]] = [];
                            }

                            $updates[$value[1]][] = [
                                'values_new' => [
                                    'alertdate' => date('Y-m-d H:i:s', $value[0]['dtend_array'][2] - 1),
                                    'content' => $content ?? '',
                                    'description' => $description ?? '',
                                    'details' => $value[0]['location'] ?? '',
                                    'enddate' => date('Y-m-d H:i:s', $value[0]['dtend_array'][2] - 1),
                                    'startdate' => date('Y-m-d H:i:s', $value[0]['dtstart_array'][2]),
                                    'category' => 'target',
                                ],
                                'values_old' => [
                                    'alertdate' => $target['alertdate'],
                                    'content' => $target['content'],
                                    'description' => $target['description'],
                                    'details' => $target['details'],
                                    'enddate' => $target['enddate'],
                                    'startdate' => $target['startdate'],
                                    'category' => 'target',
                                ],
                            ];
                        }
                    }
                }
            } else {
                rex_sql::factory()
                    ->setQuery('

                        INSERT INTO
                        dd_target
                        SET
                        alertdate = :alertdate,
                        calendar_id = :calendar_id,
                        clients = :clients,
                        content = :content,
                        createdate = :createdate,
                        description = :description,
                        details = :details,
                        enddate = :enddate,
                        startdate = :startdate,
                        status = :status,
                        tags = :tags,
                        updatedate = :updatedate

                    ', [

                        'alertdate' => date('Y-m-d H:i:s', $value[0]['dtend_array'][2] - 1),
                        'calendar_id' => $value[0]['uid'],
                        'clients' => implode(',', $clients) ?? '',
                        'content' => $content ?? '',
                        'createdate' => date('Y-m-d H:i:s', time()),
                        'description' => $description ?? '',
                        'details' => $value[0]['location'] ?? '',
                        'enddate' => date('Y-m-d H:i:s', $value[0]['dtend_array'][2] - 1),
                        'startdate' => date('Y-m-d H:i:s', $value[0]['dtstart_array'][2]),
                        'status' => 1,
                        'tags' => implode(',', $tags) ?? '',
                        'updatedate' => date('Y-m-d H:i:s', time()),

                    ]);

                if(
                    !str_contains($value[0]['description'], '##hidden') &&
                    !str_contains($value[0]['description'], '##muted') &&
                    (
                        in_array($value[0]['location'], ['pausiert', 'storniert', 'wartend']) ||
                        (
                            !$value[0]['location'] &&
                            $value[0]['dtend_array'][2] > time()
                        )
                    )
                ) {
                    foreach($clients as $value[1]) {
                        if(!array_key_exists($value[1], $updates)) {
                            $updates[$value[1]] = [];
                        }

                        $updates[$value[1]][] = [
                            'values_new' => [
                                'alertdate' => date('Y-m-d H:i:s', $value[0]['dtend_array'][2] - 1),
                                'content' => $content ?? '',
                                'description' => $description ?? '',
                                'details' => $value[0]['location'] ?? '',
                                'enddate' => date('Y-m-d H:i:s', $value[0]['dtend_array'][2] - 1),
                                'startdate' => date('Y-m-d H:i:s', $value[0]['dtstart_array'][2]),
                                'category' => 'target',
                            ],
                            'values_old' => [
                                'alertdate' => '',
                                'content' => '',
                                'description' => '',
                                'details' => '',
                                'enddate' => '',
                                'startdate' => '',
                                'category' => '',
                            ],
                        ];
                    }
                }
            }
        }

        dd_sql::reindex('dd_target');
    }

    if($updates) {
        $receivers = rex_sql::factory()
            ->getArray('

                SELECT
                *
                FROM
                dd_receiver
                WHERE
                harvest_id != ""
                AND
                status = 1

            ');

        $value = [];

        foreach($receivers as $value[0]) {
            if(!$value[0]['channels']) {
                continue;
            }

            $canceledMeetings = false;
            // $canceledTargets = false;
            $channels = explode(',', $value[0]['channels']);
            $duplicates = dd::addToList($value[0]['harvest_id'], $value[0]['duplicates']);
            $finishedTargets = false;
            $message = [];
            $value[0]['updates'] = [];
            $waitingTargets = false;

            $duplicates = explode(',', $duplicates);

            foreach($duplicates as $value[1]) {
                if(array_key_exists($value[1], $updates)) {
                    foreach($updates[$value[1]] as $value[2]) {
                        $value[0]['updates'][] = $value[2];
                    }
                }
            }

            if($value[0]['updates']) {
                usort($value[0]['updates'], function($a, $b): int {
                    return
                        ($a['values_new']['startdate'] <=> $b['values_new']['startdate']) * 100 +
                        ($a['values_new']['enddate'] <=> $b['values_new']['enddate']) * 10 +
                        ($a['values_new']['description'] <=> $b['values_new']['description']);
                });

                $url = dd::fullUrl(32, rex_getUrl(32, null, ['token' => dd::formatedToken($value[0]['token'])]));

                $message[0] = '

                    <p>Geschätzte Kundin, geschätzter Kunde</p>

                    <p>Da die Entwicklung einer Website sehr komplex sein kann und immer mit «Notfällen» und anderen Faktoren, die man nicht vorhersehen kann, gerechnet werden muss, habe ich beschlossen, nur noch unverbindliche Fristen anzugeben. Das ist in meiner und verwandten Branchen eher ungewöhnlich, aber auch realitätsnaher.</p>

                    <p>Vor diesem Hintergrund rechne ich im Moment mit den folgenden Fristen und melde mich wieder bei dir, wenn ich eines deiner Projekte abgeschlossen habe und wir es besprechen können:</p>

                    <table border="1" cellpadding="10" cellspacing="0" width="100%" style="
                        margin-bottom: 30px;
                        margin-top: 30px;
                    ">
                        <tr>
                            <th width="33.333333%">Beschreibung</th>
                            <th width="33.333333%">Kategorie</th>
                            <th width="33.333333%">Datum</th>
                        </tr>

                ';

                foreach($value[0]['updates'] as $value[1]) {
                    if($value[1]['values_new']['category'] == 'meeting') {
                        $newDate = dd::date(strtotime($value[1]['values_new']['startdate']));
                        $oldDate = $value[1]['values_old']['startdate'] ? dd::date(strtotime($value[1]['values_old']['startdate'])) : null;
                        $category = 'Besprechung';
                    } else {
                        $newDate = dd::date(strtotime($value[1]['values_new']['enddate']) + 1);
                        $oldDate = $value[1]['values_old']['enddate'] ? dd::date(strtotime($value[1]['values_old']['enddate']) + 1) : null;
                        $category = 'Projekt';
                    }

                    $newDate = $value[1]['values_new']['details'] ? $value[1]['values_new']['details'] : $newDate;
                    $oldDate = $value[1]['values_old']['details'] ? $value[1]['values_old']['details'] : $oldDate;

                    $oldDate = $newDate == $oldDate ? null : $oldDate;

                    $newDate = $oldDate ? '<span class="dd-text-danger">' . $newDate . '</span> ' : $newDate;
                    $oldDate = $oldDate ? '<span style="text-decoration: line-through;">' . $oldDate . '</span> ' : $oldDate;

                    $message[0] .= '

                        <tr>
                            <td width="33.333333%">' . $value[1]['values_new']['description'] . '</td>
                            <td width="33.333333%">' . $category . '</td>
                            <td width="33.333333%">' . $oldDate . $newDate . '</td>
                        </tr>

                    ';

                    $newContent = $value[1]['values_new']['content'];
                    $oldContent = $value[1]['values_old']['content'];

                    if($newContent && $newContent != $oldContent) {
                        $message[0] .= '

                            <tr>
                                <td colspan="4" width="100%">

                        ';

                        if($oldContent) {
                            $message[0] .= '

                                        <span style="
                                            font-size: 87.5%;
                                            font-style: italic;
                                            text-decoration: line-through;
                                        ">' . $oldContent . '</span>

                            ';
                        }

                        $message[0] .= '

                                    <span class="dd-text-danger" style="
                                        font-size: 87.5%;
                                        font-style: italic;
                                    ">

                        ';

                        $newContent = explode(PHP_EOL, $newContent);
                        $newContent = dd::cleanArray($newContent);

                        $index = 0;

                        foreach($newContent as $value[2]) {
                            $message[0] .= $index > 0 ? '. – ' : null;
                            $message[0] .= $value[2];

                            $index++;
                        }

                        $message[0]  = str_replace('.. – ', '. – ', $message[0]);

                        $message[0] .= '

                                    </span>
                                </td>
                            </tr>

                        ';
                    }

                    if(
                        in_array(2, $channels) &&
                        $value[1]['values_new']['category'] == 'meeting' &&
                        !$value[1]['values_new']['details'] &&
                        strtotime($value[1]['values_new']['startdate']) > time() - 900 &&
                        strtotime($value[1]['values_new']['startdate']) - 7200 <= time() &&
                        (
                            !$value[1]['values_old']['alertdate'] ||
                            strtotime($value[1]['values_old']['alertdate']) < strtotime($value[1]['values_new']['startdate']) - 7200 ||
                            (
                                !$value[1]['values_new']['details'] &&
                                $value[1]['values_old']['details']
                            ) ||
                            (
                                $value[1]['values_old']['startdate'] &&
                                strtotime($value[1]['values_new']['startdate']) < strtotime($value[1]['values_old']['startdate'])
                            )
                        )
                    ) {
                        $message[1]  = 'Hiermit erinnere ich dich gerne an deinen Termin am ' . str_replace(', ', ' um ', dd::date(strtotime($value[1]['values_new']['startdate']))) . '.' . "\n\n";
                        $message[1] .= '––' . "\n";
                        $message[1] .= 'Disch Development' . "\n";
                        $message[1] .= 'Maik Disch';

                        dd::message($value[0]['telephone'], $message[1]);
                    }

                    if(
                        !$canceledMeetings &&
                        in_array(2, $channels) &&
                        $value[1]['values_new']['category'] == 'meeting' &&
                        $value[1]['values_new']['details'] &&
                        $value[1]['values_new']['details'] == 'storniert'
                    ) {
                        $message[1]  = 'Ich habe einen deiner Termine storniert. Weitere Informationen habe ich dir per E-Mail gesendet.' . "\n\n";
                        $message[1] .= '––' . "\n";
                        $message[1] .= 'Disch Development' . "\n";
                        $message[1] .= 'Maik Disch';

                        dd::message($value[0]['telephone'], $message[1]);

                        $canceledMeetings = true;
                    }

                    if(
                        !$waitingTargets &&
                        in_array(2, $channels) &&
                        $value[1]['values_new']['category'] == 'target' &&
                        $value[1]['values_new']['details'] &&
                        $value[1]['values_new']['details'] == 'wartend'
                    ) {
                        $message[1]  = 'Ich warte auf weitere Anweisungen zu einem deiner Projekte. Weitere Informationen habe ich dir per E-Mail gesendet.' . "\n\n";
                        $message[1] .= '––' . "\n";
                        $message[1] .= 'Disch Development' . "\n";
                        $message[1] .= 'Maik Disch';

                        dd::message($value[0]['telephone'], $message[1]);

                        $waitingTargets = true;
                    }

                    // if(
                    //     !$canceledTargets &&
                    //     in_array(2, $channels) &&
                    //     $value[1]['values_new']['category'] == 'target' &&
                    //     $value[1]['values_new']['details'] &&
                    //     $value[1]['values_new']['details'] == 'storniert'
                    // ) {
                    //     $message[1]  = 'Ich habe eines deiner Projekte storniert. Weitere Informationen habe ich dir per E-Mail gesendet.' . "\n\n";
                    //     $message[1] .= '––' . "\n";
                    //     $message[1] .= 'Disch Development' . "\n";
                    //     $message[1] .= 'Maik Disch';
                    //
                    //     dd::message($value[0]['telephone'], $message[1]);
                    //
                    //     $canceledTargets = true;
                    // }

                    // if(
                    //     !$finishedTargets &&
                    //     in_array(2, $channels) &&
                    //     $value[1]['values_new']['category'] == 'target' &&
                    //     $value[1]['values_new']['details'] &&
                    //     $value[1]['values_new']['details'] == 'erledigt'
                    // ) {
                    //     $message[1]  = 'Ich habe eines deiner Projekte abgeschlossen. Weitere Informationen habe ich dir per E-Mail gesendet.' . "\n\n";
                    //     $message[1] .= '––' . "\n";
                    //     $message[1] .= 'Disch Development' . "\n";
                    //     $message[1] .= 'Maik Disch';
                    //
                    //     dd::message($value[0]['telephone'], $message[1]);
                    //
                    //     $finishedTargets = true;
                    // }
                }

                $message[0] .= '

                    </table>

                    <p>Weitere Informationen findest du unter dem folgenden Link:</p>

                    <p><a href="' . $url . '" target="_blank">' . $url . '</a></p>

                    <p>Vielen Dank für das Verständnis und die Geduld!</p>

                ';

                $footer = '

                    <p style="font-size: 87.5%; font-style: italic;">Nachrichten wie diese werden automatisch gesendet, auch wenn ich dich darin persönlich und manchmal auch namentlich anspreche.</p>

                ';

                if(in_array(1, $channels)) {
                    dd::mail(

                        $value[0]['email'],

                        'Deine Projekte und Termine',

                        $message[0],

                        $footer,

                        null,

                        null,

                        true

                    );
                }
            }
        }
    }
}

return true;