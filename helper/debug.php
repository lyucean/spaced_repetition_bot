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
// debug display timer
if (!function_exists('ddt')) {
    function ddt()
    {
        static $script_execution_time;
        if ($script_execution_time) {
            echo '<pre>' . PHP_EOL;
            echo 'Время выполнения скрипта: ' . round(microtime(true) - $script_execution_time, 5) . ' сек.';
            die;
        } else {
            $script_execution_time = microtime(true);
        }
    }
}
