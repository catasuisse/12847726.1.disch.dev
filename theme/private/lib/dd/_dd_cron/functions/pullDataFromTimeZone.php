<?php

$trip = rex_sql::factory()
    ->getArray('

                SELECT
                *
                FROM
                dd_trip
                WHERE
                region = :region
                OR
                timezone = :timezone
                ORDER BY
                id ASC

            ', [

        'region' => '',
        'timezone' => '',

    ]);

if(!$trip) {
    // Is correct here, because otherwise an error is written into the log:
    return true;
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

            ', [

        'id' => $trip['id'],
        'region' => $timezone['regionName'],
        'timezone' => $timezone['zoneName'],
        'updatedate' => date('Y-m-d H:i:s', time()),

    ]);

return true;