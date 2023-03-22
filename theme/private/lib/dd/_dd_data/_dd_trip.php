<?php

class dd_trip
{
    public static function all($ignoreOfflines = false)
    {
        $trips = [];

        foreach(dd::data('trips') as $value) {
            if(!$ignoreOfflines && !$value['status']) {
                continue;
            }

            $trips[] = $value;
        }

        return $trips;
    }

    public static function country($articleKey = null)
    {
        $country = self::get()['country'];
        $country = dd::wildcard($country);

        $articles = substr($country, strpos($country, '[') + 1, strpos($country, ']') - 1);
        $articles = str_replace(' ', null, $articles);
        $articles = explode(',', $articles);

        if(strpos($country, ']')) {
            $country = substr($country, strpos($country, ']') + 1);
            $country = trim($country);
        }

        if(!is_null($articleKey) && $articles && array_key_exists($articleKey, $articles)) {
            $country = $articles[$articleKey] . ' ' . $country;
        }

        return $country;
    }

    public static function get($time = null)
    {
        $trip = false;

        if(!$time) {
            $time = time();
        }

        $trips = self::all();

        foreach($trips as $value) {
            if(strtotime($value['startdate']) <= $time && strtotime($value['enddate']) >= $time) {
                $trip = $value;

                break;
            }
        }

        if(!$trip) {
            $trip = dd::settings('contact');
        }

        return $trip;
    }

    public static function timeZone()
    {
        $timeZone = [];

        $contact = dd::settings('contact');
        $trips = self::all();

        foreach($trips as $value) {
            if($value['timezone'] && strtotime($value['startdate']) <= time() && strtotime($value['enddate']) >= time()) {
                $timeZone['country'] = $value['country'];
                // $timeZone['timezone'] = $value['timezone'];

                break;
            }
        }

        if(!$timeZone) {
            $timeZone['country'] = $contact['country'];
            // $timeZone['timezone'] = $contact['timezone'];
        }

        $timeZone['country'] = dd::wildcard($timeZone['country']);
        $timeZone['timezone'] = $contact['timezone'];

        if(strpos($timeZone['country'], ']')) {
            $timeZone['country'] = substr($timeZone['country'], strpos($timeZone['country'], ']') + 1);
            $timeZone['country'] = trim($timeZone['country']);
        }

        return $timeZone;
    }

    public static function tripAndDate($time = null)
    {
        $date = dd::date($time);
        $trip = self::get($time);

        $trip = dd::place(
            $trip['place'],
            $trip['region'],
            $trip['country']
        );

        $tripAndDate  = $trip;
        $tripAndDate .= '. – ';
        $tripAndDate .= $date;

        return $tripAndDate;
    }
}
