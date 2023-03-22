<?php

$favorites = dd_data::favorites(true);

if(!$favorites) {
    // Is correct here, because otherwise an error is written into the log:
    return true;
}

foreach($favorites as $value) {
    if(!$value['enddate'] || ($value['enddate'] && strtotime($value['enddate']) >= time())) {
        continue;
    }

    rex_sql::factory()->setQuery('

                DELETE FROM
                dd_favorite
                WHERE
                id = ' . $value['id'] . '

            ');
}

dd_sql::reindex('dd_favorite');

return true;