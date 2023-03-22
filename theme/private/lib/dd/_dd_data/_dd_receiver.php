<?php

class dd_receiver
{
    public static function all($ignoreOfflines = false)
    {
        $receivers = [];

        foreach(dd::data('receivers') as $value) {
            if(!$ignoreOfflines && !$value['status']) {
                continue;
            }

            $receivers[] = $value;
        }

        return $receivers;
    }

    public static function clients($ignoreOfflines = false)
    {
        $clients = [];

        foreach(self::all($ignoreOfflines) as $value) {
            if(!in_array(3, explode(',', $value['audiences']))) {
                continue;
            }

            $clients[] = $value;
        }

        return $clients;
    }

    public static function exclude($keywords)
    {
        $exclude = false;

        $keywords = !is_array($keywords) ? ['id' => $keywords] : $keywords;
        $excludes = self::excludes();

        foreach($keywords as $key => $value) {
            $key = array_column($excludes, $key);
            $key = array_search($value, $key);

            if($key !== false) {
                $exclude = $excludes[$key];

                break;
            }
        }

        return $exclude;
    }

    public static function excludes()
    {
        return dd::data('excludes');
    }

    public static function follower($keywords, $ignoreOfflines = false)
    {
        $follower = false;

        $keywords = !is_array($keywords) ? ['id' => $keywords] : $keywords;
        $followers = self::followers($ignoreOfflines);

        foreach($keywords as $key => $value) {
            $key = array_column($followers, $key);
            $key = array_search($value, $key);

            if($key !== false) {
                $follower = $followers[$key];

                break;
            }
        }

        return $follower;
    }

    public static function followers($ignoreOfflines = false)
    {
        $followers = [];

        foreach(self::all($ignoreOfflines) as $value) {
            if(!in_array(2, explode(',', $value['audiences']))) {
                continue;
            }

            $followers[] = $value;
        }

        return $followers;
    }

    public static function friend($keywords, $ignoreOfflines = false)
    {
        $friend = false;

        $keywords = !is_array($keywords) ? ['id' => $keywords] : $keywords;
        $friends = self::friends($ignoreOfflines);

        foreach($keywords as $key => $value) {
            $key = array_column($friends, $key);
            $key = array_search($value, $key);

            if($key !== false) {
                $friend = $friends[$key];

                break;
            }
        }

        return $friend;
    }

    public static function friends($ignoreOfflines = false)
    {
        $friends = [];

        foreach(self::all($ignoreOfflines) as $value) {
            if(!in_array(1, explode(',', $value['audiences']))) {
                continue;
            }

            $friends[] = $value;
        }

        return $friends;
    }

    public static function get($keywords)
    {
        $receiver = false;

        $keywords = !is_array($keywords) ? ['id' => $keywords] : $keywords;
        $receivers = self::all(true);

        foreach($keywords as $key => $value) {
            $key = array_column($receivers, $key);
            $key = array_search($value, $key);

            if($key !== false) {
                $receiver = $receivers[$key];

                break;
            }
        }

        return $receiver;
    }

    public static function islander($keywords, $ignoreOfflines = false)
    {
        $islander = false;

        $keywords = !is_array($keywords) ? ['id' => $keywords] : $keywords;
        $islanders = self::islanders($ignoreOfflines);

        foreach($keywords as $key => $value) {
            $key = array_column($islanders, $key);
            $key = array_search($value, $key);

            if($key !== false) {
                $islander = $islanders[$key];

                break;
            }
        }

        return $islander;
    }

    public static function islanders($ignoreOfflines = false)
    {
        $islanders = [];

        foreach(dd::data('islanders') as $value) {
            if(!$ignoreOfflines && (!$value['status'] || $value['activatedate'])) {
                continue;
            }

            $islanders[] = $value;
        }

        return $islanders;
    }

    public static function prospect($keywords)
    {
        $prospect = false;

        $keywords = !is_array($keywords) ? ['id' => $keywords] : $keywords;
        $prospects = self::prospects();

        foreach($keywords as $key => $value) {
            $key = array_column($prospects, $key);
            $key = array_search($value, $key);

            if($key !== false) {
                $prospect = $prospects[$key];

                break;
            }
        }

        return $prospect;
    }

    public static function prospects()
    {
        return dd::data('prospects');
    }
}
