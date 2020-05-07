<?php

require_once __DIR__ . '/vendor/autoload.php';

use srbot\Controller\MessageProcessing;
use srbot\Controller\Schedule;

// While we will have everything in one process

// Checking the schedule, whether someone needs to send a message
(new  Schedule())->check();

// Reply to all messages
(new  MessageProcessing())->getMessage();

// Let's create a mailing list for the day.
(new  Schedule())->generate();
