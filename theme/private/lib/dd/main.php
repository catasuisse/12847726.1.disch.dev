<?php

require_once rex_path::base('theme/data/_main.php');
require_once rex_path::base('theme/data/_settings.php');

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

class dd
{
    public static function addToList($values, $list)
    {
        $list = explode(',', $list);
        $values = !is_array($values) ? [$values] : $values;

        foreach($values as $value) {
            if(!in_array($value, $list)) {
                $list[] = $value;
            }
        }

        $list = self::cleanArray($list);
        $list = implode(',', $list);

        return $list;
    }

    public static function cleanArray($array)
    {
        $array = array_filter($array);
        $array = array_filter($array, function($value) { return preg_match('#\S#', $value); });
        $array = array_map('trim', $array);
        $array = array_values($array);

        return $array;
    }

    public static function data(...$keys)
    {
        global $_DATA;

        $data = $_DATA;

        foreach($keys as $key) {
            if(!array_key_exists($key, $data)) {
                return false;

                break;
            }

            $data = $data[$key];
        }

        if(is_string($data)) {
            $data = trim($data);
        }

        return $data;
    }

    public static function date($startTime, $endTime = null)
    {
        $date = null;
        $endDate = false;
        $startDate = date('d.m.Y', $startTime);
        $startTime = date('H:i', $startTime);

        if($endTime) {
            $endDate = date('d.m.Y', $endTime);
            $endTimeCorrected = date('H:i', $endTime + 1);

            $endDate = $endDate != $startDate ? $endDate : null;
            $endTime = date('H:i', $endTime);

            if($startTime == '00:00' && $endTime == '23:59') {
                $endTime = null;
                $startTime = null;

                if(substr($startDate, -7) == substr($endDate, -7)) {
                    $startDate = substr($startDate, 0, 3);
                } else if(substr($startDate, -4) == substr($endDate, -4)) {
                    $startDate = substr($startDate, 0, 6);
                }
            }

            if($endTime) {
                $endTime = $endTimeCorrected;
            }
        }

        $date  = $startDate;
        $date .= $startTime ? ', ' . $startTime : null;
        $date .= $startTime && ($endDate || (!$endDate && !$endTime)) ? ' Uhr' : null;
        $date .= $endDate || $endTime ? ' – ' : null;
        $date .= $endDate ? $endDate : null;
        $date .= $endDate && $endTime ? ', ' : null;
        $date .= $endTime ? $endTime . ' Uhr' : null;
        $date .= ' (Zürich)';

        return $date;
    }

    public static function destiny()
    {
        $destiny = true;

        $destiny = $destiny ? self::numberIsPrime(rand(0, 999999)) : $destiny;

        $destiny = $destiny ? self::numberIsPrime(rand(0, 999999)) : $destiny;

        $destiny = $destiny ? self::numberIsPrime(rand(0, 999999)) : $destiny;

        return $destiny;
    }

    public static function documentRoot()
    {
        return $_SERVER['DOCUMENT_ROOT'] ? $_SERVER['DOCUMENT_ROOT'] : rex::getProperty('document_root')['website'];
    }

    public static function fullUrl($articleId, $url = null)
    {
        $fullUrl = $url;

        $domain = rex_yrewrite::getDomainByArticleId($articleId);

        if(!$domain) {
            return false;
        }

        $domain = $domain->getUrl();
        $domain = substr($domain, -1) == '/' ? substr($domain, 0, -1) : $domain;

        $fullUrl = !str_contains($fullUrl, $domain) ? $domain . $fullUrl : $fullUrl;

        return $fullUrl;
    }

    function bytes($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');
    
        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }

    public static function formatedToken($token)
    {
        $formatedToken = null;

        for($index = 0; $index < ceil(strlen($token) / 8); $index++) {
            $formatedToken .= ($index > 0 ? '-' : null) . substr($token, $index * 8, 8);
        }

        $formatedToken = trim($formatedToken);

        return $formatedToken;
    }

    public static function internalRefferer()
    {
        $internalRefferer = false;

        if(array_key_exists('HTTP_REFERER', $_SERVER) && $_SERVER['HTTP_REFERER']) {
            $internalRefferer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        }

        if($internalRefferer != 'disch.dev' && $internalRefferer != 'disch.xyz') {
            $internalRefferer = false;
        }

        return $internalRefferer;
    }

    public static function mail($to, $subject, $message, $footer = null, $template = null, $from = null, $copy = null)
    {
        if(!$to) {
            return false;
        }

        if(!$template) {
            $template = 'default';
        }

        try {
            $mail = new rex_mailer();

            $mail->addAddress($to);
            $mail->Body = dd_part::mail($message, $footer, $template);
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = $subject;

            if(
                is_array($from) &&
                array_key_exists(0, $from) &&
                $from[0] &&
                array_key_exists(1, $from) &&
                $from[1]
            ) {
                $mail->addReplyTo($from[0], $from[1]);
            } else if(
                is_array($from) &&
                array_key_exists(0, $from) &&
                $from[0]
            ) {
                $mail->addReplyTo($from[0]);
            } else {
                $mail->addReplyTo('info@stadelmannpartner.ch', 'Stadelmann und Partner Immobilien');
            }

            $mail->send();

            if($copy) {
                $mail = new rex_mailer();

                $mail->addAddress('info@stadelmannpartner.ch');
                $mail->Body = dd_part::mail($message, $footer, 'admin');
                $mail->CharSet = 'UTF-8';
                $mail->isHTML(true);
                $mail->Subject = $subject;

                if(
                    is_array($from) &&
                    array_key_exists(0, $from) &&
                    $from[0] &&
                    array_key_exists(1, $from) &&
                    $from[1]
                ) {
                    $mail->addReplyTo($from[0], $from[1]);
                } else {
                    $mail->addReplyTo('info@stadelmannpartner.ch', 'Stadelmann und Partner Immobilien');
                }

                $mail->send();
            }
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }

    public static function message($to = null, $message)
    {
        if(!$to) {
            return false;
        }

        try {
            dd_api::push('twilio', 'message', [
                'message' => $message,
                'receiver' => $to,
            ]);
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }

    public static function metadata(...$values)
    {
        $createdate = array_key_exists(0, $values) && $values[0] ? self::date($values[0]) : null;
        $firstname = array_key_exists(1, $values) && $values[1] ? $values[1] : null;
        $lastname = array_key_exists(2, $values) && $values[2] ? $values[2] : null;

        if(!$firstname && !$lastname) {
            $firstname = self::settings('contact', 'firstname');
            $lastname = self::settings('contact', 'lastname');
        }

        $metadata  = $firstname;
        $metadata .= $lastname ? ' ' . substr($lastname, 0, 1) . '.' : null;
        $metadata .= $createdate ? '. – ' . $createdate : null;
        $metadata  = str_replace('..', '.', $metadata);

        return $metadata;
    }

    public static function name(...$values)
    {
        $name  = array_key_exists(0, $values) && $values[0] ? $values[0] : '–';
        $name .= ', ';
        $name .= array_key_exists(1, $values) && $values[1] ? $values[1] : '–';
        $name .= ' (';
        $name .= array_key_exists(2, $values) && $values[2] ? $values[2] : '–';
        $name .= ')';

        return $name;
    }

    public static function nav($ignoreOfflines = true)
    {
        $nav = [];
        $rootCategories = rex_category::getRootCategories($ignoreOfflines);

        foreach($rootCategories as $value) {
            $nav[] = [
                'anchor' => $value->getValue('art_anchor'),
                'icon' => $value->getValue('cat_icon'),
                'id' => $value->getId(),
                'name' => $value->getValue('catname'),
                'single' => $value->getValue('art_single'),
            ];
        }

        return $nav;
    }

    public static function numberIsPrime($value)
    {
        for($index = 2; $index < $value; $index++) {
            if($value % $index == 0) {
                return false;
            }
        }

        return true;
    }

    public static function paragraphs($text, $parse = true)
    {
        $paragraphs = null;

        $text = explode(PHP_EOL, $text);
        $text = self::cleanArray($text);

        foreach($text as $value) {
            if($parse) {
                $paragraphs .= (new Parsedown)->text($value);
            } else {
                $paragraphs .= '<p>' . $value . '</p>';
            }
        }

        return $paragraphs;
    }

    public static function permission($article = null, $post = null, $token = null)
    {
        if(!$token) {
            $token = rex_session('token');
        }

        $token = dd::unformatedToken($token);

        if($article) {
            $article = rex_article::get($article);

            if(!$article) {
                dischdev()->redirect(6);
            }

            $articleAudiences = substr($article->getValue('audiences'), 1, -1);
            $articleAudiences = str_replace('|', ',', $articleAudiences);
        } else if($post) {
            $article = dd_data::post($post);

            if(!$article) {
                self::redirect(6);
            }

            $articleAudiences = $article['audiences'];
        } else {
            return false;
        }

        if(!$articleAudiences) {
            return true;
        }

        $articleAudiences = explode(',', $articleAudiences);

        if(!$token) {
            return false;
        }

        $receiver = dd_data::receiver(['token' => $token]);

        if(!$receiver || ($receiver && !$receiver['status'])) {
            return false;
        }

        $receiverAudiences = explode(',', $receiver['audiences']);

        if(array_intersect($articleAudiences, $receiverAudiences)) {
            return true;
        }

        return false;
    }

    public static function place(...$values)
    {
        $place  = array_key_exists(0, $values) && $values[0] ? self::wildcard($values[0]) : '–';
        $place .= ' (';
        $place .= array_key_exists(1, $values) && $values[1] ? self::wildcard($values[1]) : '–';
        $place .= '), ';
        $place .= array_key_exists(2, $values) && $values[2] ? self::wildcard($values[2]) : '–';

        return $place;
    }

    public static function redirect($id = null, $clang = null, array $params = [], $separator = '&amp;')
    {
        rex_response::sendCacheControl('must-revalidate, max-age=0, no-cache, private, proxy-revalidate');
        rex_response::sendRedirect(rex_getUrl($id, $clang, $params, $separator));
    }

    public static function removeFromList($values, $list)
    {
        $list = explode(',', $list);
        $values = !is_array($values) ? [$values] : $values;

        foreach($values as $value) {
            if(($key = array_search($value, $list)) !== false) {
                unset($list[$key]);
            }
        }

        $list = self::cleanArray($list);
        $list = implode(',', $list);

        return $list;
    }

    public static function removeTags($string, $symbols = '##')
    {
        $symbols = !is_array($symbols) ? [$symbols] : $symbols;
        $value = [];

        foreach($symbols as $value[0]) {
            preg_match_all('/' . $value[0] . '(\w+)/', $string, $matches);

            foreach($matches[0] as $value[1]) {
                $string = str_replace($value[1], '', $string);
            }
        }

        $string = trim($string);

        return $string;
    }

    public static function session()
    {
        return dd_data::receiver(['token' => rex_session('token')]);
    }

    public static function settings(...$keys)
    {
        global $_SETTINGS;

        $settings = $_SETTINGS;

        foreach($keys as $key) {
            if(!array_key_exists($key, $settings)) {
                return false;

                break;
            }

            $settings = $settings[$key];
        }

        if(is_string($settings)) {
            $settings = trim($settings);
        }

        return $settings;
    }

    public static function tags($string, $symbol = '##')
    {
        $tags = [];

        preg_match_all('/' . $symbol . '(\w+)/', $string, $matches);

        foreach($matches[1] as $value) {
            $tags[] = $value;
        }

        $tags = array_unique($tags);
        $tags = array_values($tags);

        return $tags;
    }

    public static function telephone($telephone = null)
    {
        if(!$telephone) {
            return false;
        }

        $telephone = [
            'global' => $telephone,
            'local' => $telephone,
            'normal' => $telephone,
        ];

        if(substr($telephone['normal'], 0, 3) == '+41') {
            $telephone['global'] =
                substr($telephone['global'], 0, 3) .
                ' ' .
                substr($telephone['global'], 3, 2) .
                ' ' .
                substr($telephone['global'], 5, 3) .
                ' ' .
                substr($telephone['global'], 8, 2) .
                ' ' .
                substr($telephone['global'], 10, 2);

            $telephone['local'] = str_replace('+41', '0', $telephone['local']);
            $telephone['local'] =
                substr($telephone['local'], 0, 3) .
                ' ' .
                substr($telephone['local'], 3, 3) .
                ' ' .
                substr($telephone['local'], 6, 2) .
                ' ' .
                substr($telephone['local'], 8, 2);
        }

        return $telephone;
    }

    public static function token()
    {
        $tokenIsUnique = false;
        $token = bin2hex(openssl_random_pseudo_bytes(32));

        while(!$tokenIsUnique) {
            $tokenIsUnique = true;

            $briefing = rex_sql::factory()
                ->getArray('

                    SELECT
                    *
                    FROM
                    dd_briefing
                    WHERE
                    upload_token = :token

                ', [

                    'token' => $token,

                ]);

            $comment = rex_sql::factory()
                ->getArray('

                    SELECT
                    *
                    FROM
                    dd_comment
                    WHERE
                    token = :token

                ', [

                    'token' => $token,

                ]);

            $feedback = rex_sql::factory()
                ->getArray('

                    SELECT
                    *
                    FROM
                    dd_feedback
                    WHERE
                    upload_token = :token

                ', [

                    'token' => $token,

                ]);

            $islander = rex_sql::factory()
                ->getArray('

                    SELECT
                    *
                    FROM
                    dd_islander
                    WHERE
                    token = :token

                ', [

                    'token' => $token,

                ]);

            $prospect = rex_sql::factory()
                ->getArray('

                    SELECT
                    *
                    FROM
                    dd_prospect
                    WHERE
                    token = :token

                ', [

                    'token' => $token,

                ]);

            $receiver = rex_sql::factory()
                ->getArray('

                    SELECT
                    *
                    FROM
                    dd_receiver
                    WHERE
                    token = :token

                ', [

                    'token' => $token,

                ]);

            $upload = rex_sql::factory()
                ->getArray('

                    SELECT
                    *
                    FROM
                    dd_upload
                    WHERE
                    upload_token = :token

                ', [

                    'token' => $token,

                ]);

            if(
                $briefing ||
                $comment ||
                $feedback ||
                $islander ||
                $prospect ||
                $receiver ||
                $upload
            ) {
                $tokenIsUnique = false;
            }

            if(!$tokenIsUnique) {
                $token = bin2hex(openssl_random_pseudo_bytes(32));
            }
        }

        return $token;
    }

    public static function truncate($string, $limit = null)
    {
        $string = nl2br($string);

        $string = preg_replace('/<br\W*?\/>/', ' ', $string);

        $string = preg_replace('/\s+/', ' ', $string);

        if(!$limit || strlen($string) <= $limit) {
            return $string;
        }

        if(false !== ($breakpoint = strpos($string, ' ', $limit))) {
            if($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint);
            }
        }

        if(!ctype_alpha(substr($string, -1)) && !is_numeric(substr($string, -1))) {
            $string = substr($string, 0, -1);
        }

        $string = $string . ' ...';

        return $string;
    }

    public static function unformatedToken($token)
    {
        $unformatedToken = str_replace('-', '', $token);

        return $unformatedToken;
    }

    public static function weather($latitude, $longitude) {
        try {
            $weather = file_get_contents('https://api.open-meteo.com/v1/forecast?latitude=' . $latitude . '&longitude=' . $longitude . '&current_weather=true');
            $weather = json_decode($weather, true);
            $weather = $weather['current_weather'];

            return $weather;
        } catch (Exception $exception) {
            return false;
        }
    }

    public static function wildcard($value)
    {
        $wildcard = sprogcard($value);

        if(!$wildcard) {
            $wildcard = $value;
        }

        return $wildcard;
    }
}
