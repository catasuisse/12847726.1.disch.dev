<?php

if(rex::isFrontend()) {

    // error_reporting(0);

    rex_login::startSession();

    if(rex_get('token')) {
        rex_unset_session('token');

        rex_set_session('token', dd::unformatedToken(rex_get('token')));
    }

} else {

    rex_extension::register('GLOB_META_UPDATED', ['dd_table', 'update'], rex_extension::LATE);
    rex_extension::register('YFORM_DATA_ADDED', ['dd_table', 'create'], rex_extension::LATE);
    rex_extension::register('YFORM_DATA_DELETED', ['dd_table', 'delete'], rex_extension::LATE);
    rex_extension::register('YFORM_DATA_LIST', ['dd_table', 'list'], rex_extension::LATE);
    rex_extension::register('YFORM_DATA_LIST_SQL', ['dd_table', 'query'], rex_extension::LATE);
    rex_extension::register('YFORM_DATA_UPDATED', ['dd_table', 'update'], rex_extension::LATE);

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    if(rex::getUser()) {

        rex_extension::register('PAGES_PREPARED', function(rex_extension_point $extensionPoint) {
            $page = rex_be_controller::getPageObject('multiupload');
            $page->setHidden(true);
        });

        rex_extension::register('PAGES_PREPARED', function(rex_extension_point $extensionPoint) {
            $page = rex_be_controller::getPageObject('yform');
            $page->setHidden(true);
        });

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        //

        if(rex::getUser()->isAdmin()) {

            //

            /*
            ––––––––––––––––––––––––––––––––––––––––––––––––––
            */

            //

        }

    }

}

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

function dd_availability() {
    return new dd_availability;
}

function dd_api() {
    return new dd_api;
}

function dd_cron() {
    return new dd_cron;
}

function dd_data() {
    return new dd_data;
}

function dd_disk() {
    return new dd_disk;
}

function dd_form() {
    return new dd_form;
}

function dd_helper() {
    return new dd_helper;
}

function dd_part() {
    return new dd_part;
}

function dd_post() {
    return new dd_post;
}

function dd_receiver() {
    return new dd_receiver;
}

function dd_seo() {
    return new dd_seo;
}

function dd_sql() {
    return new dd_sql;
}

function dd_time() {
    return new dd_time;
}

function dd_trip() {
    return new dd_trip;
}

function dischdev() {
    return new dd;
}
