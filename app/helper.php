<?php

// debug display function
if (!function_exists('ddf')) {
    function ddf($var, $die = true)
    {
        echo '<pre>' . PHP_EOL;
        print_r($var);
        if ($die) {
            die;
        }
    }
}
