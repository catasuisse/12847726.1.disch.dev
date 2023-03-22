<?php

$exception = dd_data::exception();

if(!$exception || ($exception && (!array_key_exists('enddate', $exception) || !$exception['enddate']))) {
    // Is correct here, because otherwise an error is written into the log:
    return true;
}

$exception['enddate'] = date('Y-m-d H:i:s', dd_time::get(strtotime($exception['enddate'])));

if(strtotime($exception['enddate']) < time()) {
    rex_sql::factory()
        ->setQuery('

                    UPDATE
                    rex_global_settings
                    SET
                    glob_exception_contact = :glob_exception_contact,
                    glob_exception_email = :glob_exception_email,
                    glob_exception_enddate = :glob_exception_enddate,
                    glob_exception_meetings = :glob_exception_meetings,
                    glob_exception_telephone = :glob_exception_telephone

                ', [

            'glob_exception_contact' => '',
            'glob_exception_email' => '',
            'glob_exception_enddate' => '',
            'glob_exception_meetings' => 1,
            'glob_exception_telephone' => '',

        ]);

    rex_global_settings::deleteCache();
}

return true;