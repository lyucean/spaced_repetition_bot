<?php

$notifier = new Airbrake\Notifier(
    array(
        'projectId' => 276279,
        "environment" => ENVIRONMENT,
        'projectKey' => '351c192a20c2a278a0961e173bc5698e'
    )
);

Airbrake\Instance::set($notifier);

$handler = new Airbrake\ErrorHandler($notifier);
$handler->register();

//try {
//    throw new Exception('Test');
//} catch (Exception $e) {
//    Airbrake\Instance::notify($e);
//}

