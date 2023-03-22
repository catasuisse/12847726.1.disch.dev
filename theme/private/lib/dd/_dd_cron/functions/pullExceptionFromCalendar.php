<?php

$exceptions = dd_api::pull('calendar', 'meetings');
$targets = dd_api::pull('calendar', 'targets');

if(!$exceptions || !$targets) {
    return true;
}

$exceptions = array_merge($exceptions, $targets);

$descriptionContact = '';
$descriptionTelephone = '';

if($exceptions) {
    foreach($exceptions as $value) {
        if($value['dtstart_array'][2] <= time() && $value['dtend_array'][2] > time()) {
            if(str_contains($value['description'], '##lunch')) {
                $descriptionContact = 'Ich bin in der Mittagspause und um ca. ' . date('H:i', $value['dtend_array'][2]) . ' Uhr zurück.';
                $descriptionTelephone = 'lunch.mp3';
            } else if(str_contains($value['description'], '##meeting')) {
                $descriptionContact = 'Ich bin in einer Besprechung und um ca. ' . date('H:i', $value['dtend_array'][2]) . ' Uhr zurück.';
                $descriptionTelephone = 'meeting.mp3';
            } else if(str_contains($value['description'], '##overload')) {
                $descriptionContact = '';
                $descriptionTelephone = 'overload.mp3';
            } else if(str_contains($value['description'], '##rejection')) {
                $descriptionContact = '';
                $descriptionTelephone = 'rejection.mp3';
            }

            break;
        }
    }
}

rex_sql::factory()
    ->setQuery('

                UPDATE
                dd_exception
                SET
                description_contact = :description_contact,
                description_telephone = :description_telephone,
                updatedate = :updatedate

            ', [

        'description_contact' => $descriptionContact,
        'description_telephone' => $descriptionTelephone,
        'updatedate' => date('Y-m-d H:i:s', time()),

    ]);

return true;