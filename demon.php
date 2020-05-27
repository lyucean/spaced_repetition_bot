<?php

require_once __DIR__ . '/vendor/autoload.php';

use srbot\model\Processing;
use srbot\model\Schedule;

// While we will have everything in one process
//if($_SERVER['USERNAME'] != 'lyucean'){
//    die;
//}

// Checking the schedule, whether someone needs to send a message
(new  Schedule())->check();

// Reply to all messages, once per second
$minute = gmdate("i");
$processing = new  Processing();
while ($minute == gmdate("i")) {
    echo gmdate("i:s"), PHP_EOL;
    $processing->checkMessage();
    sleep(1);
}

// Let's create a mailing list for the day.
(new  Schedule())->generate();

