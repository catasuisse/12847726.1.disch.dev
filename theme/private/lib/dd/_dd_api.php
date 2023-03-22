<?php

class dd_api
{
    public static function pull($target, $action, $optionalParameter = null)
    {
        $server = rex::getServer() == 'https://disch.local:8890/' ? 'https://api.disch.local:8890/' : 'https://api.disch.dev/';

        $parameter = [
            'action' => $action,
            'token' => dd::settings('api', 'token'),
        ];

        if($optionalParameter && is_array($optionalParameter)) {
            foreach($optionalParameter as $key => $value) {
                $value = is_array($value) ? json_encode($value) : $value;

                $parameter[$key] = $value;
            }
        }

        $curlHandler = curl_init();

        curl_setopt($curlHandler, CURLOPT_URL, $server . $target . '/pull.php?' . http_build_query($parameter, null, '&'));

        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curlHandler);

        curl_close($curlHandler);

        $response = json_decode($response, true);

        return $response;
    }

    public static function push($target, $action, $optionalParameter = null)
    {
        $server = rex::getServer() == 'https://disch.local:8890/' ? 'https://api.disch.local:8890/' : 'https://api.disch.dev/';

        $parameter = [
            'action' => $action,
            'token' => dd::settings('api', 'token'),
        ];

        if($optionalParameter && is_array($optionalParameter)) {
            foreach($optionalParameter as $key => $value) {
                $value = is_array($value) ? json_encode($value) : $value;

                $parameter[$key] = $value;
            }
        }

        $curlHandler = curl_init();

        curl_setopt($curlHandler, CURLOPT_URL, $server . $target . '/push.php');

        curl_setopt($curlHandler, CURLOPT_POST, true);
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $parameter);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curlHandler);

        curl_close($curlHandler);

        return $response;
    }
}
