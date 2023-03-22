<?php

$trips = dd_api::pull('nomadlist', 'trips');

if(!$trips) {
    return true;
}

$nomadListIds = [];

foreach($trips as $value) {
    $nomadListIds[] = $value['trip_id'];
}

if($nomadListIds) {
    rex_sql::factory()->setQuery('

                DELETE FROM
                dd_trip
                WHERE
                nomadlist_id NOT IN (' . rex_sql::factory()->in($nomadListIds) . ')

            ');
}

if($trips) {
    $trips = array_reverse($trips);

    foreach($trips as $value) {
        $trip = rex_sql::factory()
            ->getArray('

                        SELECT
                        *
                        FROM
                        dd_trip
                        WHERE
                        nomadlist_id = :nomadlist_id

                    ', [

                'nomadlist_id' => $value['trip_id'],

            ]);

        if($trip) {
            continue;
        }

        $enddate = date('Y-m-d', $value['epoch_end']) . ' 00:00:00';
        $enddate = strtotime($enddate) + 86399;
        $enddate = date('Y-m-d H:i:s', $enddate);

        $startdate = date('Y-m-d', $value['epoch_start']) . ' 00:00:00';
        $startdate = strtotime($startdate);
        $startdate = date('Y-m-d H:i:s', $startdate);

        rex_sql::factory()
            ->setQuery('

                        INSERT INTO
                        dd_trip
                        SET
                        coordinates = :coordinates,
                        country = :country,
                        country_code = :country_code,
                        createdate = :createdate,
                        enddate = :enddate,
                        nomadlist_id = :nomadlist_id,
                        place = :place,
                        region = :region,
                        startdate = :startdate,
                        status = :status,
                        timezone = :timezone,
                        updatedate = :updatedate

                    ', [

                'coordinates' => $value['latitude'] . ', ' . $value['longitude'],
                'country' => $value['country'],
                'country_code' => $value['country_code'],
                'createdate' => date('Y-m-d H:i:s', time()),
                'enddate' => $enddate,
                'nomadlist_id' => $value['trip_id'],
                'place' => $value['place'],
                'region' => '',
                'startdate' => $startdate,
                'status' => 1,
                'timezone' => '',
                'updatedate' => date('Y-m-d H:i:s', time()),

            ]);

        dd_sql::reindex('dd_trip');
    }
}

return true;