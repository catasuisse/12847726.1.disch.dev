<?php

$friends = dd_data::friends(true);

uasort($friends, function($a, $b): int {
    return
        ($a['lastname'] <=> $b['lastname']) * 100 +
        ($a['firstname'] <=> $b['firstname']) * 10 +
        ($a['harvest_id'] <=> $b['harvest_id']);
});

$content  = null;

$content .= '

    <table class="table table-hover dd-table-friends">
        <thead>
            <tr>
                <th class="rex-table-icon">_</th>
                <th>ID</th>
                <th>Nach- und Vorname</th>
                <th>Beziehung</th>
                <th>E-Mail</th>
                <th>SMS</th>
                <th>Funktionen</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

';

foreach($friends as $value) {
    $channels = explode(',', $value['channels']);
    $email = $value['email'];
    $status = '<span class="rex-offline"><i class="rex-icon rex-icon-offline"></i>&nbsp;<span class="text">offline</span></span>';
    $telephone = $value['telephone'];

    if($value['status']) {
        $status = '<span class="rex-online"><i class="rex-icon rex-icon-online"></i>&nbsp;<span class="text">online</span></span>';
    }

    if($email && !in_array(1, $channels)) {
        $email = '<span style="color: #d9534f; text-decoration: line-through;">' . $email . '</span>';
    }

    if($telephone && !in_array(2, $channels)) {
        $telephone = '<span style="color: #d9534f; text-decoration: line-through;">' . $telephone . '</span>';
    }

    $functions = '

        <div class="dropdown yform-dropdown">
            <button class="btn btn-xs btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                Aktion&nbsp;<span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
                
            </ul>
        </div>
    
    ';

    $content .= '

        <tr>
            <td class="rex-table-icon"><span class="text-muted"><i class="rex-icon rex-icon-user"></i></span></td>
            <td>' . $value['id'] . '</td>
            <td>' . $value['lastname'] . ', ' . $value['firstname'] . ($value['callname'] ? ' (' . $value['callname'] . ')' : null) . '</td>
            <td>' . $value['relation'] . '</td>
            <td>' . $email . '</td>
            <td>' . $telephone . '</td>
            <td>' . $functions . '</td>
            <td>' . $status . '</td>
        </tr>

    ';
}

$content .= '

        </tbody>
    </table>

';

$fragment = new rex_fragment();
$fragment->setVar('content', $content, false);
$fragment->setVar('title', 'Freunde', false);

echo rex_view::title('Freunde');
echo $fragment->parse('core/page/section.php');
