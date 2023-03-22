<?php

$availability = dd_api::pull('calendly', 'availability');

if(!$availability) {
    return true;
}

rex_sql::factory()
    ->setQuery('

                UPDATE
                dd_availability
                SET
                friday = :friday,
                monday = :monday,
                saturday = :saturday,
                sunday = :sunday,
                thursday = :thursday,
                timezone = :timezone,
                tuesday = :tuesday,
                updatedate = :updatedate,
                wednesday = :wednesday

            ', [

        'friday' => $availability['rules'][5],
        'monday' => $availability['rules'][1],
        'saturday' => $availability['rules'][6],
        'sunday' => $availability['rules'][0],
        'thursday' => $availability['rules'][4],
        'timezone' => $availability['timezone'],
        'tuesday' => $availability['rules'][2],
        'updatedate' => date('Y-m-d H:i:s', time()),
        'wednesday' => $availability['rules'][3],

    ]);

return true;