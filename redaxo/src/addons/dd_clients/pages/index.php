<?php

$clients = dd_data::clients(true);

uasort($clients, function($a, $b): int {
    return
        ($a['lastname'] <=> $b['lastname']) * 100 +
        ($a['firstname'] <=> $b['firstname']) * 10 +
        ($a['harvest_id'] <=> $b['harvest_id']);
});

$content  = null;

$content .= '

    <table class="table table-hover dd-table-clients">
        <thead>
            <tr>
                <th class="rex-table-icon">_</th>
                <th>ID</th>
                <th>Nach- und Vorname</th>
                <th>Kundennummer</th>
                <th>E-Mail</th>
                <th>SMS</th>
                <th class="rex-table-action">Funktion</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

';

foreach($clients as $value) {
    $channels = explode(',', $value['channels']);
    $email = $value['email'];
    $icon = '<span class="text-muted"><i class="rex-icon rex-icon-user"></i></span>';
    $meetings = '<span class="text-muted"><i class="rex-icon rex-icon-execute"></i>&nbsp;Termine anzeigen</span>';
    $status = '<span class="rex-offline"><i class="rex-icon rex-icon-offline"></i>&nbsp;<span class="text">offline</span></span>';
    $telephone = $value['telephone'];

    if($value['status']) {
        $icon = '<a class="rex-link-expanded" href="' . dd::fullUrl(32, rex_getUrl(32, null, ['token' => dd::formatedToken($value['token'])])) . '" target="_blank"><i class="rex-icon rex-icon-user"></i></a>';
        $meetings = '<a href="' . dd::fullUrl(32, rex_getUrl(32, null, ['token' => dd::formatedToken($value['token'])])) . '" target="_blank"><i class="rex-icon rex-icon-execute"></i>&nbsp;Termine anzeigen</a>';
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
                <li>' . $meetings . '</li>
            </ul>
        </div>
    
    ';

    $content .= '

        <tr>
            <td class="rex-table-icon">' . $icon . '</td>
            <td>' . $value['id'] . '</td>
            <td>' . $value['lastname'] . ', ' . $value['firstname'] . ($value['callname'] ? ' (' . $value['callname'] . ')' : null) . '</td>
            <td>@@' . str_replace(',', ', @@', $value['harvest_id']) . '</td>
            <td>' . $email . '</td>
            <td>' . $telephone . '</td>
            <td class="rex-table-action">' . $functions . '</td>
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
$fragment->setVar('title', 'Kunden', false);

echo rex_view::title('Kunden');
echo $fragment->parse('core/page/section.php');
