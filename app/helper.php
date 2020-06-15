<?php

// debug display function
if (!function_exists('ddf')) {
    /**
     * @param $var
     * @param bool $die
     */
    function ddf($var, $die = true)
    {
        echo '<pre>' . PHP_EOL;
        print_r($var);
        flush();
        if ($die) {
            die;
        }
    }
}

// get query param
if (!function_exists('get_var_query')) {
    /**
     * @param string $string
     * @return array
     */
    function get_var_query(string $string)
    {
        $string = parse_url($string);

        if (empty($string['query'])) {
            return [];
        }

        parse_str($string['query'], $query);

        return $query;
    }
}

// remove_http
if (!function_exists('remove_http')) {
    /**
     * @param $url
     * @return string|string[]
     */
    function remove_http($url)
    {
        $disallowed = array('http://', 'https://', 'http://www.', 'https://www.');
        foreach ($disallowed as $d) {
            if (strpos($url, $d) === 0) {
                return str_replace($d, '', $url);
            }
        }
        return $url;
    }
}

// wrapper for Yandex metrics
if (!function_exists('ya_metric')) {
    /**
     * @param $id
     * @param $command
     */
    function ya_metric($id, $command)
    {
        $context = stream_context_create(
            [
                'http' => [
                    'method' => 'GET',
                    'header' => 'Accept-language: en' . PHP_EOL .
                        'Content-Type: application/javascript' . PHP_EOL .
                        'Cookie: foo=bar' . PHP_EOL .
                        'User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us)' . PHP_EOL
                ],
            ]
        );

        $url = 'https://mc.yandex.ru/watch/' . YANDEX_METRIC_ID;
        $params = [
            'wmode' => 7,
            'page-ref' => $id,
            'page-url' => $command,
            'charset' => 'utf-8',
        ];
        @file_get_contents($url . '?' . http_build_query($params), false, $context);
    }
}


