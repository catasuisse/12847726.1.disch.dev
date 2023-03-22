<?php

$absences = dd_api::pull('calendar', 'absences');

if(!$absences) {
    return true;
}

$query = '

            DELETE FROM
            dd_absence
            WHERE
            calendar_id != ""
            AND
            description_contact = ""
            AND
            description_email = ""
            AND
            post_id = "0"

        ';

$calendarIds = [];

if($absences) {
    foreach($absences as $value) {
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

if($absences) {
    foreach($absences as $value) {
        if($value['dtend_array'][2] - 1 < time() - 86400 * 7) {
            rex_sql::factory()->setQuery('

                        DELETE FROM
                        dd_absence
                        WHERE
                        calendar_id = :calendar_id

                    ', [

                'calendar_id' => $value['uid'],

            ]);

            continue;
        }

        $content = $value['description'];
        $descriptionAbsences = $value['summary'];
        $descriptionTelephone = 'absence.mp3';

        $descriptionAbsences = str_replace(' *', '', $descriptionAbsences);
        $descriptionAbsences = trim($descriptionAbsences);

        if(str_contains($content, '##private')) {
            $descriptionAbsences = 'Privater Termin';
        }

        if(str_contains($content, '##vacation')) {
            $descriptionTelephone = 'vacation.mp3';
        }

        $content = explode('##', $content);
        $content = $content[0];
        $content = trim($content);

        $absence = rex_sql::factory()
            ->getArray('

                        SELECT
                        *
                        FROM
                        dd_absence
                        WHERE
                        calendar_id = "' . $value['uid'] . '"

                    ');

        if($absence) {
            $absence = $absence[0];

            rex_sql::factory()
                ->setQuery('

                            UPDATE
                            dd_absence
                            SET
                            content = :content,
                            description_absences = :description_absences,
                            description_telephone = :description_telephone,
                            details = :details,
                            enddate = :enddate,
                            startdate = :startdate,
                            updatedate = :updatedate
                            WHERE
                            id = :id

                        ', [

                    'content' => $content ?? '',
                    'description_absences' => $descriptionAbsences ?? '',
                    'description_telephone' => $descriptionTelephone,
                    'details' => $value['location'] ?? '',
                    'enddate' => date('Y-m-d H:i:s', $value['dtend_array'][2] - 1),
                    'id' => $absence['id'],
                    'startdate' => date('Y-m-d H:i:s', $value['dtstart_array'][2]),
                    'updatedate' => date('Y-m-d H:i:s', time()),

                ]);
        } else {
            rex_sql::factory()
                ->setQuery('

                            INSERT INTO
                            dd_absence
                            SET
                            calendar_id = :calendar_id,
                            content = :content,
                            createdate = :createdate,
                            description_absences = :description_absences,
                            description_telephone = :description_telephone,
                            details = :details,
                            enddate = :enddate,
                            startdate = :startdate,
                            status = :status,
                            updatedate = :updatedate

                        ', [

                    'calendar_id' => $value['uid'],
                    'content' => $content ?? '',
                    'createdate' => date('Y-m-d H:i:s', time()),
                    'description_absences' => $descriptionAbsences ?? '',
                    'description_telephone' => $descriptionTelephone,
                    'details' => $value['location'] ?? '',
                    'enddate' => date('Y-m-d H:i:s', $value['dtend_array'][2] - 1),
                    'startdate' => date('Y-m-d H:i:s', $value['dtstart_array'][2]),
                    'status' => 1,
                    'updatedate' => date('Y-m-d H:i:s', time()),

                ]);
        }
    }

    dd_sql::reindex('dd_absence');
}

return true;