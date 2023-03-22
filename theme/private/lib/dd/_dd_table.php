<?php

class dd_table
{
    public static function create($extensionPoint)
    {
        $id = $extensionPoint->getParam('data_id');
        $table = $extensionPoint->getParam('table')->getTableName();

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_post') {
            self::notifyReceiversAboutPost($id);
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_islander') {
            $islander = rex_sql::factory()
                ->getArray('

                    SELECT
                    *
                    FROM
                    dd_islander
                    WHERE
                    id = :id

                ', [

                    'id' => $id,

                ]);

            if(!$islander) {
                exit;
            }

            $islander = $islander[0];

            if(!$islander['token']) {
                rex_sql::factory()
                    ->setQuery('

                        UPDATE
                        dd_islander
                        SET
                        token = :token
                        WHERE
                        id = :id

                    ', [

                        'id' => $islander['id'],
                        'token' => dd::token(),

                    ]);
            }
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_receiver') {
            $receiver = rex_sql::factory()
                ->getArray('

                    SELECT
                    *
                    FROM
                    dd_receiver
                    WHERE
                    id = :id

                ', [

                    'id' => $id,

                ]);

            if(!$receiver) {
                exit;
            }

            $receiver = $receiver[0];

            if(!$receiver['token']) {
                rex_sql::factory()
                    ->setQuery('

                        UPDATE
                        dd_receiver
                        SET
                        token = :token
                        WHERE
                        id = :id

                    ', [

                        'id' => $receiver['id'],
                        'token' => dd::token(),

                    ]);
            }
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_trip') {
            self::enrichTripWithTimezone($id);
        }
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    public static function delete($extensionPoint)
    {
        $id = $extensionPoint->getParam('data_id');
        $oldValues = $extensionPoint->getParam('old_data');
        $table = $extensionPoint->getParam('table')->getTableName();

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_post') {
            //
        }
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    public static function enrichTripWithTimezone($id)
    {
        $trip = rex_sql::factory()
            ->getArray('

                SELECT
                *
                FROM
                dd_trip
                WHERE
                id = :id

            ', [

                'id' => $id,

            ]);

        if(!$trip) {
            exit;
        }

        $trip = $trip[0];

        $timezone = dd_api::pull('timezone', 'timezone', ['coordinates' => $trip['coordinates']]);

        rex_sql::factory()
            ->setQuery('

                UPDATE
                dd_trip
                SET
                region = :region,
                timezone = :timezone,
                updatedate = :updatedate
                WHERE
                id = :id
                AND
                (
                    region = ""
                    OR
                    timezone = ""
                )

            ', [

                'id' => $trip['id'],
                'region' => $timezone['regionName'],
                'timezone' => $timezone['zoneName'],
                'updatedate' => date('Y-m-d H:i:s', time()),

            ]);
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    public static function list($extensionPoint)
    {
        $subject = $extensionPoint->getSubject();
        $table = $extensionPoint->getParam('table')->getTableName();

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_absence') {
            $subject->setColumnLabel('description_absences', 'Beschreibung');
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_call') {
            // $subject->setColumnFormat('audio', 'custom', function($parameter) {
            //     $list = $parameter['list'];
            
            //     $audio = '
                
            //         <audio controls preload="none">
            //             <source src="https://api.twilio.com/2010-04-01/Accounts/AC873008df5ac61c297538741cd8c7cd73/Recordings/' . $list->getValue('audio') . '" type="audio/wav">
            //         </audio>

            //     ';
            
            //     return $audio;
            // });
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_catchment') {
            $subject->setColumnLabel('status_toggle', 'Status');
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_comment') {
            $subject->setColumnLabel('status_toggle', 'Status');
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_favorite') {
            $subject->setColumnLabel('status_toggle', 'Status');
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_post') {
            $subject->setQuery($subject->getQuery()->whereRaw('audiences != 9'));

            $subject->setColumnLabel('status_toggle', 'Status');
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_receiver') {
            // $subject->setColumnFormat('lastname', 'custom', function($parameter) {
            //     $list = $parameter['list'];
            //
            //     $name = dd::name($list->getValue('lastname'), $list->getValue('firstname'), $list->getValue('callname'));
            //
            //     return $name;
            // });
            // $subject->setColumnLabel('lastname', 'Nach- und Vorname');

            /*
            ––––––––––––––––––––––––––––––––––––––––––––––––––
            */

            // $subject->setColumnFormat('telephone', 'custom', function($parameter) {
            //     $list = $parameter['list'];
            //
            //     $telephone = dd::telephone($list->getValue('telephone'));
            //     $telephone = $telephone ? $telephone['global'] : null;
            //
            //     return $telephone;
            // });

            $subject->setColumnLabel('status_toggle', 'Status');
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_tag') {
             $subject->setColumnFormat('name', 'custom', function($parameter) {
                 $list = $parameter['list'];

                 return '#' . $list->getValue('name');
             });
        }
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    public static function notifyReceiversAboutPost($id)
    {
        $post = rex_sql::factory()
            ->getArray('

                SELECT
                *
                FROM
                dd_post
                WHERE
                id = :id

            ', [

                'id' => $id,

            ]);

        if(!$post) {
            return false;
        }

        $post = $post[0];

        // if($post['audiences'] == 9) {
        //     dd_post::notifyIslanders();
        // }

        $notification = dd_post::notifyReceivers($post);

        if($notification) {
            echo rex_view::success('E-Mails wurden gesendet.');
        }

        return $notification;
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    public static function query($extensionPoint)
    {
        $table = $extensionPoint->getParam('table')->getTableName();

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_absence') {
            dd_cron::pullAbsencesFromCalendar();
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_availability') {
            dd_cron::pullAvailabilityFromCalendly();
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_exception') {
            dd_cron::pullExceptionFromCalendar();
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_favorite') {
            dd_cron::deleteUnusedFavorites();
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_invoice') {
            dd_cron::pullInvoicesFromHarvest();
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_meeting') {
            dd_cron::pullMeetingsAndTargetsFromCalendar();
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        // if($table == 'dd_receiver') {
        //     dd_cron::pullClientsFromHarvest();
        // }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_target') {
            dd_cron::pullMeetingsAndTargetsFromCalendar();
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($table == 'dd_trip') {
            dd_cron::pullDataFromNomadList();
        }
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    public static function update($extensionPoint)
    {
        if($extensionPoint->getName() == 'GLOB_META_UPDATED') {

            //

        } else {

            $id = $extensionPoint->getParam('data_id');
            $oldValues = $extensionPoint->getParam('old_data');
            $table = $extensionPoint->getParam('table')->getTableName();

            /*
            ––––––––––––––––––––––––––––––––––––––––––––––––––
            */

            if($table == 'dd_comment') {
                $comment = [];

                $comment[0] = rex_sql::factory()
                    ->getArray('

                        SELECT
                        *
                        FROM
                        dd_comment
                        WHERE
                        id = :id

                    ', [

                        'id' => $id,

                    ]);

                if(!$comment[0]) {
                    exit;
                }

                $comment[0] = $comment[0][0];

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
                        parent = :parent,
                        post = :post,
                        status = :status,
                        token = :token,
                        updatedate = :updatedate

                    ', [

                        'callname' => '',
                        'content' => $comment[0]['reply'],
                        'createdate' => date('Y-m-d H:i:s', time()),
                        'email' => dd::settings('contact', 'email'),
                        'firstname' => dd::settings('contact', 'firstname'),
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'lastname' => dd::settings('contact', 'lastname'),
                        'parent' => $comment[0]['id'],
                        'post' => $comment[0]['post'],
                        'status' => 1,
                        'token' => dd::token(),
                        'updatedate' => date('Y-m-d H:i:s', time()),

                    ]);

                rex_sql::factory()
                    ->setQuery('

                        UPDATE
                        dd_comment
                        SET
                        reply = :reply
                        WHERE
                        id = :id

                    ', [

                        'id' => $comment[0]['id'],
                        'reply' => '',

                    ]);

                $comment[1] = rex_sql::factory()
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

                if(!$comment[1]) {
                    exit;
                }

                $comment[1] = $comment[1][0];

                $receiver = rex_sql::factory()
                    ->getArray('

                        SELECT
                        *
                        FROM
                        dd_receiver
                        WHERE
                        email = :email

                    ', [

                        'email' => $comment[0]['email'],

                    ]);

                if($receiver) {
                    $receiver = $receiver[0];
                }

                $triggered = false;

                if($comment[0]['notification']) {
                    $post = dd_post::get($comment[1]['post']);

                    if(!$post) {
                        exit;
                    }

                    $callname = [];
                    $date = str_replace(', ', ' um ', dd::date(strtotime($comment[0]['createdate'])));
                    $url = dd::fullUrl(24, rex_getUrl('', '', ['post_id' => $comment[1]['post']])) . '#dd-comment-' . str_pad($comment[1]['id'], 6, 0, STR_PAD_LEFT);

                    $callname[0] = $comment[0]['callname'];

                    if(!$callname[0] && $comment[0]['firstname'] && $comment[0]['lastname']) {
                        $callname[0] = $comment[0]['firstname'] . ' ' . substr($comment[0]['lastname'], 0, 1) . '.';
                    }

                    $callname[1] = $comment[1]['callname'];

                    if(!$callname[1] && $comment[1]['firstname'] && $comment[1]['lastname']) {
                        $callname[1] = $comment[1]['firstname'] . ' ' . substr($comment[1]['lastname'], 0, 1) . '.';
                    }

                    if($receiver) {
                        $callname[0] = $receiver['callname'] ? $receiver['callname'] : $receiver['firstname'];
                        $url = dd::fullUrl(24, rex_getUrl('', '', ['post_id' => $comment[1]['post'], 'token' => dd::formatedToken($receiver['token'])])) . '#dd-comment-' . str_pad($comment[1]['id'], 6, 0, STR_PAD_LEFT);
                    }

                    $message = '

                        <p>Hallo ' . $callname[0] . '</p>

                        <p>' . $callname[1] . ' hat deinen Kommentar vom ' . $date . ' zu meinem Beitrag «' . $post['title'] . '» beantwortet:</p>

                        <p><a href="' . $url . '" target="_blank">' . $url . '</a></p>

                    ';

                    $url = dd::fullUrl(27, rex_getUrl(27, '', ['case' => 2, 'token' => dd::formatedToken($comment[0]['token'])]));

                    $footer = '

                        <p style="font-size: 87.5%; font-style: italic;">Nachrichten wie diese werden automatisch gesendet, auch wenn ich dich darin persönlich und manchmal auch namentlich anspreche. Wenn du keine Nachrichten wie diese mehr erhalten möchtest, öffne bitte den folgenden Link:</p>

                        <p style="font-size: 87.5%; font-style: italic;"><a href="' . $url . '" target="_blank">' . $url . '</a></p>

                    ';

                    dd::mail(

                        $comment[0]['email'],

                        'Neuer Kommentar von ' . $callname[1],

                        $message,

                        $footer

                    );

                    $triggered = true;
                }

                if($triggered) {
                    echo rex_view::success('E-Mail wurde gesendet.');
                }
            }

            /*
            ––––––––––––––––––––––––––––––––––––––––––––––––––
            */

            if($table == 'dd_post') {
                if($oldValues['newsletter']) {
                    return false;
                }

                self::notifyReceiversAboutPost($id);
            }

            /*
            ––––––––––––––––––––––––––––––––––––––––––––––––––
            */

            if($table == 'dd_receiver') {
                $receiver = rex_sql::factory()
                    ->getArray('

                        SELECT
                        *
                        FROM
                        dd_receiver
                        WHERE
                        id = :id

                    ', [

                        'id' => $id,

                    ]);

                if(!$receiver) {
                    exit;
                }

                $receiver = $receiver[0];

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

                        'email_new' => $receiver['email'],
                        'email_old' => $oldValues['email'],
                        'firstname' => $receiver['firstname'],
                        'lastname' => $receiver['lastname'],

                    ]);
            }

            /*
            ––––––––––––––––––––––––––––––––––––––––––––––––––
            */

            if($table == 'dd_trip') {
                self::enrichTripWithTimezone($id);
            }

        }
    }
}
