<?php

$availability = rex_sql::factory()->getArray('SELECT * FROM dd_availability')[0];

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

global $_SETTINGS;

$_SETTINGS = [

    'api' => [

        'token' => 'FWT29cyl8Hv0Fp2LD92J2Eb5Ydm0xw7fv7SnBK9gOzM9uOi7A3',

    ],

    'contact' => [

        'coordinates' => '46.982146, 9.57612',

        'country' => 'Schweiz',

        'country_code' => 'CH',

        'email' => 'help@disch.dev',

        'facebook' => 'https://www.facebook.com/dischdev',

        'firstname' => 'Maik',

        'instagram' => 'https://www.instagram.com/dischdev',

        'lastname' => 'Disch',

        'linkedin' => 'https://www.linkedin.com/company/dischdev',

        'place' => 'Malans',

        'postal_code_and_place' => '7208 Malans GR',

        'region' => 'Graubünden',

        'street_and_house' => 'Unterdorfstrasse 15',

        'telephone' => '+41815110513',

        'timezone' => $availability['timezone'],

    ],

    'disk' => [

        'path' => dirname(rex_path::base()) . '/disk.disch.dev',

    ],

    'mail' => [

        'signature' => '

            <p>
                Liebe Grüsse<br />
                Maik<br />
            </p>

            <p>
                ––<br />
                <b>Disch Development</b><br />
                Maik Disch<br />
                maik@disch.dev<br />
                081 511 05 13
            </p>

        ',

    ],

];
