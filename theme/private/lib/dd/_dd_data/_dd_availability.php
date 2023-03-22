<?php

class dd_availability
{
    public static function all($day = null)
    {
        $availabilities = dd::data('availabilities');
        $key = [];
        $value = [];

        foreach($availabilities as $key[0] => $value[0]) {
            if(!$value[0]) {
                continue;
            }

            $value[0] = explode(' – ', $value[0]);

            foreach($value[0] as $key[1] => $value[1]) {
                $value[0][$key[1]] = date('H:i', dd_time::get(strtotime($value[1])));
            }

            $value[0] = implode(' – ', $value[0]);

            $availabilities[$key[0]] = $value[0];
        }

        if($day && array_key_exists($day, $availabilities) && $availabilities[$day]) {
            return $availabilities[$day];
        } else if($day) {
            return false;
        }

        return $availabilities;
    }

    public static function exception()
    {
        $exception = dd::data('exception');

        if(
            array_key_exists('sickness', $exception) &&
            $exception['sickness']
        ) {
            $exception['meetings'] = 0;

            if(
                !array_key_exists('contact', $exception) ||
                !$exception['contact']
            ) {
                $exception['contact'] = 'Ich bin krank und arbeite darum im Moment nicht.';
            }

            if(
                !array_key_exists('email', $exception) ||
                !$exception['email']
            ) {
                $exception['email'] = 'Vielen Dank für deine Nachricht. Ich bin krank und arbeite darum im Moment nicht. Ich beantworte sie gerne, wenn ich wieder gesund bin.';
            }

            if(
                !array_key_exists('telephone', $exception) ||
                !$exception['telephone']
            ) {
                $exception['telephone'] = 'sickness.mp3';
            }
        }

        if(
            (
                !array_key_exists('contact', $exception) ||
                !$exception['contact']
            ) &&
            (
                !array_key_exists('telephone', $exception) ||
                !$exception['telephone']
            )
        ) {
            $exceptions = rex_sql::factory()->getArray('SELECT * FROM dd_exception ORDER BY id DESC LIMIT 1');

            if($exceptions) {
                $value = $exceptions[0];

                $exception['contact'] = $value['description_contact'];
                $exception['telephone'] = $value['description_telephone'];
            }
        }

        return $exception;
    }

    public static function get($time = null)
    {
        if(!$time) {
            $time = time();
        }

        $availabilities = self::all();

        $dayOfWeek = dd_time::dayOfWeek($time);
        $iteration = -1;

        for($index = $dayOfWeek; $index <= count($availabilities); $index++) {
            $availability = null;
            $continue = false;
            $daylightSavingTime = date('I', time());
            $iteration++;

            if(array_key_exists($index, $availabilities) && $availabilities[$index] && str_contains($availabilities[$index], ' – ')) {
                $availability = explode(' – ', $availabilities[$index]);

                $closing = strtotime(date('Y-m-d', $time) . ' ' . $availability[1] . ':00') + $iteration * 86400;
                $opening = strtotime(date('Y-m-d', $time) . ' ' . $availability[0] . ':00') + $iteration * 86400;

                $closing = $closing <= $opening ? $closing + 86400 : $closing;

                if(!$daylightSavingTime && date('I', $closing)) {
                    $closing = $closing - 3600;
                } else if($daylightSavingTime && !date('I', $closing)) {
                    $closing = $closing + 3600;
                }

                if(!$daylightSavingTime && date('I', $opening)) {
                    $opening = $opening - 3600;
                } else if($daylightSavingTime && !date('I', $opening)) {
                    $opening = $opening + 3600;
                }

                foreach(dd_event::absences() as $value) {
                    $endDate = strtotime($value['enddate']) + 1;
                    $startDate = strtotime($value['startdate']);

                    if($startDate <= $opening && $endDate >= $closing) {
                        $continue = true;

                        break;
                    }

                    if($startDate > $opening && $startDate < $closing && $endDate >= $closing) {
                        $closing = $startDate;
                    }

                    if($endDate > $opening && $endDate < $closing && $startDate <= $opening) {
                        $opening = $endDate;
                    }

                    if($closing <= $opening) {
                        $continue = true;

                        break;
                    }
                }

                if(($index == $dayOfWeek && $closing <= $time) || $continue) {
                    continue;
                }

                $closing = date('Y-m-d H:i:s', $closing);
                $opening = date('Y-m-d H:i:s', $opening);

                $availability = [
                    'closing' => $closing,
                    'opening' => $opening,
                ];

                break;
            }

            if($index == count($availabilities)) {
                $index = 0;
            }
        }

        return $availability;
    }

    public static function status($strict = false)
    {
        $absence = dd_data::absence();
        $availability = self::get();
        $exception = self::exception();

        if($strict && $exception && $exception['telephone'] && $exception['telephone'] != 'noise.mp3') {
            return false;
        } else if($exception && $exception['contact']) {
            return false;
        }

        if($absence) {
            return false;
        }

        if(
            !$availability ||
            (
                $availability &&
                (
                    strtotime($availability['opening']) > time() ||
                    strtotime($availability['closing']) < time()
                )
            )
        ) {
            return false;
        }

        return true;
    }
}
