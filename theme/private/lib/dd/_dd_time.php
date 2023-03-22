<?php

class dd_time
{
    public static function dayOfWeek($time = null)
    {
        if(!$time) {
            $time = time();
        }

        return date('w', $time);
    }

    public static function get($time = null, $inputTimeZone = null, $outputTimeZone = null)
    {
        if(!$inputTimeZone) {
            $inputTimeZone = dd::settings('contact', 'timezone');
        }

        if(!$time) {
            $time = time();
        }

        if(!$outputTimeZone) {
            $outputTimeZone = date_default_timezone_get();
        }

        $time = (new DateTime(date('Y-m-d H:i:s', $time), new DateTimeZone($inputTimeZone)))
            ->setTimezone(new DateTimeZone($outputTimeZone))
            ->format('Y-m-d H:i:s');
        $time = strtotime($time);

        return $time;
    }

    public static function isToday($time)
    {
        if(date('Y-m-d', $time) == date('Y-m-d', time())) {
            return true;
        }

        return false;
    }

    public static function isTomorrow($time)
    {
        if(date('Y-m-d', $time) == date('Y-m-d', time() + 86400)) {
            return true;
        }

        return false;
    }

    public static function isWithinOneWeek($time)
    {
        if(strtotime(date('Y-m-d', $time) . ' 00:00:00') < strtotime(date('Y-m-d', time() + 86400 * 7) . ' 00:00:00')) {
            return true;
        }

        return false;
    }

    public static function months($key = null)
    {
        $months = [
            1 => 'Januar',
            2 => 'Februar',
            3 => 'März',
            4 => 'April',
            5 => 'Mai',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'August',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Dezember'
        ];

        if($key) {
            $months = $months[$key];
        }

        return $months;
    }

    public static function weekDays($key = null)
    {
        $weekDays = [
            0 => 'Sonntag',
            1 => 'Montag',
            2 => 'Dienstag',
            3 => 'Mittwoch',
            4 => 'Donnerstag',
            5 => 'Freitag',
            6 => 'Samstag',
        ];

        if($key) {
            $weekDays = $weekDays[$key];
        }

        return $weekDays;
    }
}
