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

// short_line_for_md
if (!function_exists('short_line_for_md')) {
    /**
     * @param string $str
     * @param int $max_line_length
     * @return string|string[]
     */
    function short_line_for_md(string $str, int $max_line_length = 1000)
    {
        $disallowed = array('https://www.', 'http://www.', 'https://', 'http://', 'www.');
        foreach ($disallowed as $d) {
            if (strpos($str, $d) === 0) {
                $text = str_replace($d, '', $str);

//                $host = parse_url($text)['host'];

                if ($max_line_length < mb_strlen($text)) {
                    $text = mb_strimwidth($text, 0, $max_line_length, "...");
                }

                return '[' . $text . '](' . $str . ')';
            }
        }

        if ($max_line_length < mb_strlen($str)) {
            $str = mb_strimwidth($str, 0, $max_line_length, "...");
        }

        return $str;
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

        //
        if ($str_pos = strpos($command, "?") !== false) {
            $command = substr($command, 0, $str_pos);
        }

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


