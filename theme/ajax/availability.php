<?php

require_once('./inc/boot.php');

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

$absence = dd_data::absence();
$availabilities = dd_data::availabilities();
$exception = dd_data::exception();
$status = dd_data::status();

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

if($exception['contact']) {
    $availability = $exception['contact'];
} else if($absence && $absence['description_contact']) {
    $availability = $absence['description_contact'];
} else {
    $dayOfWeek = dd_time::dayOfWeek();

    if($absence) {
        $time = strtotime($absence['enddate']) + 1;

        $availability = dd_data::availability($time);
    } else {
        $time = time();

        $availability = dd_data::availability();
    }

    if($availability) {
        if(dd_time::dayOfWeek(strtotime($availability['opening'])) == $dayOfWeek && dd_time::isToday(strtotime($availability['opening']))) {
            $availability = 'Heute bin ich von ' . date('H:i', strtotime($availability['opening'])) . ' bis ' . date('H:i', strtotime($availability['closing'])) . ' Uhr gut erreichbar.';
        } else if(dd_time::dayOfWeek(strtotime($availability['opening'])) == $dayOfWeek + 1 && (dd_time::isToday(strtotime($availability['opening'])) || dd_time::isTomorrow(strtotime($availability['opening'])))) {
            $availability = 'Ich bin morgen ab ' . date('H:i', strtotime($availability['opening'])) . ' Uhr wieder gut erreichbar.';
        } else if(dd_time::isWithinOneWeek(strtotime($availability['opening']))) {
            $availability = 'Ich bin am ' . dd_time::weekDays(dd_time::dayOfWeek(strtotime($availability['opening']))) . ' ab ' . date('H:i', strtotime($availability['opening'])) . ' Uhr wieder gut erreichbar.';
        } else {
            $availability = 'Ich bin am ' . date('d.m.', strtotime($availability['opening'])) . ' ab ' . date('H:i', strtotime($availability['opening'])) . ' Uhr wieder gut erreichbar.';
        }
    }
}

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

$meetings = dd_part::callToAction(
    'Rückruf sichern',
    $exception['meetings'] ? 'https://calendly.com/dischdev/meeting' : 'javascript:;',
    $exception['meetings'] ? 'target="_blank" rel="noopener noreferrer"' : null,
    $exception['meetings'] ? null : 'dd-disabled',
);

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

$feedback = [
    'availability' => $availability,
    'meetings' => $meetings,
    'status' => $status,
];

$feedback = json_encode($feedback);

echo $feedback;