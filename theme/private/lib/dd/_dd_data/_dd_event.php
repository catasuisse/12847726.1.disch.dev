<?php

class dd_event
{
    public static function absence($time = null)
    {
        $absence = false;

        if(!$time) {
            $time = time();
        }

        foreach(array_reverse(self::absences()) as $value) {
            if(strtotime($value['startdate']) <= $time && strtotime($value['enddate']) >= $time) {
                $absence = $value;

                break;
            }
        }

        return $absence;
    }

    public static function absences()
    {
        return dd::data('absences');
    }

    public static function activeAbsences()
    {
        $activeAbsences = [];

        foreach(self::absences() as $value) {
            if(strtotime($value['startdate']) > time() && strtotime($value['startdate']) < time() + 86400 * 21) {
                $activeAbsences[] = $value;
            }
        }

        return $activeAbsences;
    }

    public static function activeMeetings($duplicates)
    {
        $duplicates = !is_array($duplicates) ? [$duplicates] : $duplicates;
        $duplicates = dd::cleanArray($duplicates);

        $activeMeetings = [];
        $value = [];

        foreach(self::meetings() as $value[0]) {
            if(
                str_contains($value[0]['tags'], 'hidden') ||
                strtotime($value[0]['startdate']) < time() - 14400
            ) {
                continue;
            }

            $clients = explode(',', $value[0]['clients']);

            foreach($duplicates as $value[1]) {
                if(in_array($value[1], $clients)) {
                    $value[0]['category'] = 'meeting';

                    $activeMeetings[] = $value[0];
                }
            }
        }

        return $activeMeetings;
    }

    public static function activeMeetingsAndTargets($duplicates)
    {
        $activeMeetings = self::activeMeetings($duplicates);
        $activeTargets = self::activeTargets($duplicates);

        $activeMeetingsAndTargets = array_merge($activeMeetings, $activeTargets);

        usort($activeMeetingsAndTargets, function($a, $b): int {
            return
                ($a['startdate'] <=> $b['startdate']) * 100 +
                ($a['enddate'] <=> $b['enddate']) * 10 +
                ($a['description'] <=> $b['description']);
        });

        return $activeMeetingsAndTargets;
    }

    public static function activeTargets($duplicates)
    {
        $duplicates = !is_array($duplicates) ? [$duplicates] : $duplicates;
        $duplicates = dd::cleanArray($duplicates);

        $activeTargets = [];
        $value = [];

        foreach(self::targets() as $value[0]) {
            if(
                str_contains($value[0]['tags'], 'hidden') ||
                (
                    $value[0]['details'] != 'pausiert' &&
                    $value[0]['details'] != 'verspätet' &&
                    $value[0]['details'] != 'wartend' &&
                    strtotime($value[0]['enddate']) < time() - 86400
                )
            ) {
                continue;
            }

            $clients = explode(',', $value[0]['clients']);

            foreach($duplicates as $value[1]) {
                if(in_array($value[1], $clients)) {
                    $value[0]['category'] = 'target';

                    $activeTargets[] = $value[0];
                }
            }
        }

        return $activeTargets;
    }

    public static function meetings()
    {
        return dd::data('meetings');
    }

    public static function targets()
    {
        return dd::data('targets');
    }
}
