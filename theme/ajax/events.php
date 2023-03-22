<?php

require_once('./inc/boot.php');

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

$activeMeetingsAndTargets = null;
$duplicates = null;
$receiver = dd_data::receiver(['token' => $_POST['token']]);

$duplicates = $receiver ? dd::addToList($receiver['harvest_id'], $receiver['duplicates']) : $duplicates;

if($duplicates) {
    $duplicates = explode(',', $duplicates);

    $activeMeetingsAndTargets = dd_data::activeMeetingsAndTargets($duplicates);
}

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

if($activeMeetingsAndTargets) {
    $events  = '
    
        <table class="dd-table-meetings-targets dd-with-tags">
            <tbody>
    
    ';

    foreach($activeMeetingsAndTargets as $value) {
        $category  = '<div class="dd-tag dd-tag-';

        if($value['category'] == 'meeting') {
            $details = dd::date(strtotime($value['startdate']));
            $category .= 'meeting">Besprechung';
        } else {
            $details = dd::date(strtotime($value['enddate']) + 1);
            $category .= 'target">Projekt';
        }

        $category .= '</div>';

        $details = $value['details'] ? $value['details'] : $details;

        if($details == 'erledigt') {
            $details = '<span class="dd-text-success">' . $details . '</span>';
        } else if($details == 'pausiert') {
            $details = '<span class="dd-text-warning">' . $details . '</span>';
        } else if($details == 'storniert') {
            $details = '<span class="dd-text-danger">' . $details . '</span>';
        } else if($details == 'wartend') {
            $details = '<span class="dd-text-flash dd-text-warning">' . $details . '</span>';
        }
        
        $events .= '
        
            <tr' . ($value['content'] ? ' class="dd-highlighted"' : null) . '>
                <td' . ($value['content'] ? ' class="dd-with-content"' : null) . '>' . $category . $value['description'] . '</td>
                <td' . ($value['content'] ? ' class="dd-with-content"' : null) . '>' . $details . '</td>
            </tr>
        
        ';

        if($value['content']) {
            $events .= '
            
                <tr class="dd-content dd-highlighted">
                    <td colspan="2">' . dd::paragraphs($value['content'], false) . '</td>
                </tr>
            
            ';
        }
    }

    $events  .= '
    
            </tbody>
        </table>
    
    ';
} else {
    $events  = '
    
        <p class="dd-text-success">Im Moment gibt es keine Projekte oder Termine, die ich eingeplant habe. Vielleicht habe ich dir weitere Informationen per E-Mail gesendet.</p>
    
    ';
}

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

$feedback = [
    'events' => $events,
];

$feedback = json_encode($feedback);

echo $feedback;