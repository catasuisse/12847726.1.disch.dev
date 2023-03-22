<?php

$clients = dd_data::clients();
$value = [];

foreach($clients as $value[0]) {
    $duplicates = dd::addToList($value[0]['harvest_id'], $value[0]['duplicates']);
    $duplicates = explode(',', $duplicates);

    $meetings = dd_data::activeMeetings($duplicates);

    foreach($meetings as $value[1]) {
        if(
            !$value[1]['details'] &&
            !str_contains($value[1]['tags'], 'muted') &&
            strtotime($value[1]['startdate']) > time() &&
            strtotime($value[1]['startdate']) - 7200 <= time() &&
            strtotime($value[1]['alertdate']) < strtotime($value[1]['startdate']) - 7200
        ) {
            if($value[0]['telephone']) {
                $message  = 'Hiermit erinnere ich dich gerne an deinen Termin am ' . str_replace(', ', ' um ', dd::date(strtotime($value[1]['startdate']))) . '.' . "\n\n";
                $message .= '––' . "\n";
                $message .= 'Disch Development' . "\n";
                $message .= 'Maik Disch';

                dd_api::push('twilio', 'message', [
                    'message' => $message,
                    'receiver' => $value[0]['telephone'],
                ]);
            }

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
                    'id' => $value[1]['id'],

                ]);
        }
    }
}

return true;