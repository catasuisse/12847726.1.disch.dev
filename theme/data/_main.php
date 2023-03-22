<?php

$availability = rex_sql::factory()->getArray('SELECT * FROM dd_availability')[0];
$globalSettings = rex_sql::factory()->getArray('SELECT * FROM rex_global_settings')[0];

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

global $_DATA;

$_DATA = [

    'absences' => rex_sql::factory()->getArray('SELECT * FROM dd_absence ORDER BY startdate ASC, enddate ASC, createdate ASC'),

    'availabilities' => [

        0 => $availability['sunday'],

        1 => $availability['monday'],

        2 => $availability['tuesday'],

        3 => $availability['wednesday'],

        4 => $availability['thursday'],

        5 => $availability['friday'],

        6 => $availability['saturday'],

    ],

    'catchments' => rex_sql::factory()->getArray('SELECT * FROM dd_catchment'),

    'comments' => rex_sql::factory()->getArray('SELECT * FROM dd_comment ORDER BY id DESC'),

    'exception' => [

        'contact' => $globalSettings['glob_exception_contact'],

        'email' => $globalSettings['glob_exception_email'],

        'enddate' => $globalSettings['glob_exception_enddate'],

        'meetings' => $globalSettings['glob_exception_meetings'],

        'sickness' => $globalSettings['glob_exception_sickness'],

        'telephone' => $globalSettings['glob_exception_telephone'],

    ],

    'excludes' => rex_sql::factory()->getArray('SELECT * FROM dd_exclude'),

    'favorites' => rex_sql::factory()->getArray('SELECT * FROM dd_favorite'),

    'feedback' => rex_sql::factory()->getArray('SELECT * FROM dd_feedback ORDER BY id DESC'),

    'invoices' => rex_sql::factory()->getArray('SELECT * FROM dd_invoice ORDER BY target DESC, harvest_id ASC, createdate ASC'),

    'islanders' => rex_sql::factory()->getArray('SELECT * FROM dd_islander'),

    'meetings' => rex_sql::factory()->getArray('SELECT * FROM dd_meeting ORDER BY startdate ASC, enddate ASC, description ASC, createdate ASC'),

    'posts' => rex_sql::factory()->getArray('SELECT * FROM dd_post ORDER BY createdate DESC'),

    'prospects' => rex_sql::factory()->getArray('SELECT * FROM dd_prospect'),

    'receivers' => rex_sql::factory()->getArray('SELECT * FROM dd_receiver'),

    'services' => [

        'Blog erstellen lassen',

        'Branding',

        'digitale Lösungen',

        'Homepage erstellen lassen',

        'Logo erstellen lassen',

        'Programmierung',

        '<a href="https://www.redaxo.org" target="_blank" rel="noopener norefferer" title="Website von Redaxo">Redaxo (CMS)</a>',

        'Redesign',

        'Suchmaschinenoptimierung (SEO)',

        'Voice over IP (VoIP)',

        'Webagentur',

        'Webanwendungen',

        'Webapplikationen',

        'Webdesign',

        'Webentwicklung',

        'Webkonzeption',

        'Website erstellen lassen',

    ],

    'targets' => rex_sql::factory()->getArray('SELECT * FROM dd_target ORDER BY startdate ASC, enddate ASC, description ASC, createdate ASC'),

    'trips' => rex_sql::factory()->getArray('SELECT * FROM dd_trip ORDER BY enddate DESC, startdate DESC, createdate DESC'),

];
