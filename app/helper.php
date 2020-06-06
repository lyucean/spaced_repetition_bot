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
