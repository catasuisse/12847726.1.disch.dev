<?php

$notification = false;
$parameter = [];
$triggered = false;
$user = dd_api::pull('slack', 'user');
$query = null;

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

if(
    $user &&
    array_key_exists('presence', $user) &&
    $user['presence'] != dd::data('general', 'presence')
) {
    $query .= ($query ? ', ' : null) . 'glob_general_presence = :general_presence';

    $parameter['general_presence'] = $user['presence'];

    $triggered = true;
}

if(
    $user &&
    array_key_exists('status', $user) &&
    $user['status'] != dd::data('general', 'status')
) {
    $query .= ($query ? ', ' : null) . 'glob_general_status = :general_status';

    $parameter['general_status'] = $user['status'];

    $triggered = true;
}

if(
    $user &&
    array_key_exists('location', $user) &&
    array_key_exists('city', $user['location']) &&
    $user['location']['city'] != dd::locations('current', 'city')
) {
    $query .= ($query ? ', ' : null) . 'glob_current_location_city = :current_location_city';

    $parameter['current_location_city'] = $user['location']['city'];

    $notification = true;
    $triggered = true;
}

if(
    $user &&
    array_key_exists('location', $user) &&
    array_key_exists('coordinates', $user['location']) &&
    $user['location']['coordinates'] != dd::locations('current', 'coordinates')
) {
    $query .= ($query ? ', ' : null) . 'glob_current_location_coordinates = :current_location_coordinates';

    $parameter['current_location_coordinates'] = $user['location']['coordinates'];

    $notification = true;
    $triggered = true;
}

if(
    $user &&
    array_key_exists('location', $user) &&
    array_key_exists('country', $user['location']) &&
    $user['location']['country'] != dd::locations('current', 'country')
) {
    $query .= ($query ? ', ' : null) . 'glob_current_location_country = :current_location_country';

    $parameter['current_location_country'] = $user['location']['country'];

    $notification = true;
    $triggered = true;
}

if(
    $user &&
    array_key_exists('location', $user) &&
    array_key_exists('time_zone', $user['location']) &&
    $user['location']['time_zone'] != dd::locations('current', 'time_zone')
) {
    $query .= ($query ? ', ' : null) . 'glob_current_location_time_zone = :current_location_time_zone';

    $parameter['current_location_time_zone'] = $user['location']['time_zone'];

    $triggered = true;
}

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

if($query && $parameter) {
    rex_sql::factory()
        ->setQuery('

                    UPDATE rex_global_settings SET ' . $query . '

                ', $parameter);
}

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

if(!$preventNotification && $notification) {
    dd_api::push('slack', 'message', [
        'message' => 'Deine Daten wurden erfolgreich von der Website übernommen.',
    ]);
}

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

if($triggered) {
    rex_global_settings::deleteCache();

    return true;
}

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

// Is correct here, because otherwise an error is written into the log:
return true;